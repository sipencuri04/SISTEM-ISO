<?php

require_once BASE_PATH . '/app/models/M_DocumentRequest.php';
require_once BASE_PATH . '/app/models/M_User.php';

class AiService
{
    private $docModel;
    private $userModel;

    public function __construct()
    {
        $this->docModel = new M_DocumentRequest();
        $this->userModel = new M_User();
    }

    public function ask($question)
    {
        // 1. Normalisasi teks
        $q = strtolower(trim($question));
        $q = preg_replace('/[^a-z0-9 ]/', '', $q); // Hapus simbol aneh

        // 2. Logika Deteksi Pola (Rule-Based)
        
        // --- POLA 1: SAPAAN ---
        if (preg_match('/^(halo|hi|hai|selamat|pagi|siang|sore|malam)/', $q)) {
            return "Halo! Saya Assistant Sistem ISO. Ada yang bisa saya bantu terkait data dokumen atau user?";
        }

        // --- POLA 2: STATISTIK / JUMLAH ---
        if (str_contains($q, 'berapa') || str_contains($q, 'jumlah') || str_contains($q, 'total')) {
            return $this->handleCountQuery($q);
        }

        // --- POLA 3: PENCARIAN DOKUMEN ---
        if (str_contains($q, 'status') || str_contains($q, 'cari') || str_contains($q, 'dokumen')) {
            return $this->handleSearchQuery($q);
        }

        // --- POLA 4: LIST USER / DEPARTEMEN ---
        if (str_contains($q, 'siapa') || str_contains($q, 'user') || str_contains($q, 'daftar')) {
            return $this->handleUserQuery($q);
        }

        // --- FLASHBACK / FALLBACK ---
        return "Maaf, saya belum mengerti pertanyaan itu. Coba tanyakan seperti:\n" .
               "- 'Berapa jumlah dokumen?'\n" .
               "- 'Cari dokumen ISO-001'\n" .
               "- 'Siapa saja admin sistem?'";
    }

    private function handleCountQuery($q)
    {
        if (str_contains($q, 'user') || str_contains($q, 'pengguna')) {
            $users = $this->userModel->getAll();
            return "Saat ini terdaftar **" . count($users) . " user** dalam sistem.";
        }

        if (str_contains($q, 'dokumen') || str_contains($q, 'surat')) {
            $docs = $this->docModel->getMonitoring();
            $total = count($docs);
            
            // Cek spesifik status
            if (str_contains($q, 'pending') || str_contains($q, 'menunggu')) {
                $count = 0;
                foreach ($docs as $d) {
                    if (str_contains(strtolower($d['status']), 'menunggu')) $count++;
                }
                return "Ada **$count dokumen** yang sedang menunggu approval/validasi.";
            }

            if (str_contains($q, 'approve') || str_contains($q, 'setuju') || str_contains($q, 'selesai')) {
                $count = 0;
                foreach ($docs as $d) {
                    if (str_contains(strtolower($d['status']), 'approve') || str_contains(strtolower($d['status']), 'selesai')) $count++;
                }
                return "Ada **$count dokumen** yang sudah disetujui (Approved).";
            }

            return "Total ada **$total dokumen** tercatat di database.";
        }

        return "Ingin menghitung jumlah apa? User atau Dokumen?";
    }

    private function handleSearchQuery($q)
    {
        // Ekstrak kata kunci (biasanya kata terakhir atau format kode)
        // Contoh: "Cari dokumen QA-001" -> keyword "qa001"
        $words = explode(' ', $q);
        $keyword = end($words); 
        
        // Atau cari pola Kode Dokumen (misal ada angka dan huruf)
        if (preg_match('/[a-z]+[0-9]+/', $q, $matches)) {
            $keyword = $matches[0];
        }

        $docs = $this->docModel->getMonitoring();
        $found = [];

        foreach ($docs as $d) {
            // Pencarian luas (Kode, Judul, Pengaju)
            if (str_contains(strtolower($d['kode_dokumen']), $keyword) || 
                str_contains(strtolower($d['judul_baru']), $keyword) ||
                str_contains(strtolower($d['pengaju'] ?? ''), $keyword)) {
                $found[] = $d;
            }
        }

        if (empty($found)) {
            return "Saya tidak menemukan dokumen dengan kata kunci: **$keyword**.";
        }

        if (count($found) === 1) {
            $d = $found[0];
            return "Ditemukan Dokumen:\n" .
                   "📄 **{$d['kode_dokumen']}**\n" .
                   "Judul: {$d['judul_baru']}\n" .
                   "Status: **{$d['status']}**\n" .
                   "Pengaju: {$d['pengaju']}\n" .
                   "Tgl: " . date('d M Y', strtotime($d['created_at']));
        }

        // Jika banyak
        $res = "Ditemukan " . count($found) . " dokumen mirip:\n";
        $limit = array_slice($found, 0, 5);
        foreach ($limit as $d) {
            $res .= "- **{$d['kode_dokumen']}** ({$d['status']}): {$d['judul_baru']}\n";
        }
        if (count($found) > 5) $res .= "...dan lainnya.";
        
        return $res;
    }

    private function handleUserQuery($q)
    {
        $users = $this->userModel->getAll();

        // Filter Role
        $role = null;
        if (str_contains($q, 'admin')) $role = 'admin';
        if (str_contains($q, 'gm')) $role = 'gm';
        if (str_contains($q, 'hod')) $role = 'hod';
        if (str_contains($q, 'mr')) $role = 'mr';
        if (str_contains($q, 'pic')) $role = 'pic';

        if ($role) {
            $filtered = array_filter($users, fn($u) => $u['role'] === $role);
            if (empty($filtered)) return "Tidak ada user dengan role **$role**.";

            $res = "Daftar User **" . strtoupper($role) . "**:\n";
            foreach ($filtered as $u) {
                $res .= "- {$u['nama']} (Dept: {$u['departemen']})\n";
            }
            return $res;
        }

        // List Departemen
        if (str_contains($q, 'departemen') || str_contains($q, 'dept')) {
            $depts = array_unique(array_column($users, 'departemen'));
            return "Departemen yang terdaftar:\n- " . implode("\n- ", $depts);
        }

        // List Random Users
        $limit = array_slice($users, 0, 8);
        $res = "Berikut beberapa user di sistem:\n";
        foreach ($limit as $u) {
            $res .= "- {$u['nama']} ({$u['role']})\n";
        }
        return $res;
    }
}
