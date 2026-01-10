<?php

/**
 * Local AI Service - No External API Needed!
 * Rule-based AI yang query database sendiri
 */

class LocalAiService
{
    private $db;
    private $patterns;

    public function __construct($db)
    {
        $this->db = $db;
        $this->initializePatterns();
    }

    /**
     * Main ask method
     */
    public function ask($question)
    {
        $question = strtolower(trim($question));
        
        // 1. Check exact patterns
        $response = $this->matchPattern($question);
        if ($response) {
            return $response;
        }

        // 2. Check database queries
        $response = $this->queryDatabase($question);
        if ($response) {
            return $response;
        }

        // 3. Fallback response
        return $this->getFallbackResponse();
    }

    /**
     * Initialize patterns
     */
    private function initializePatterns()
    {
        $this->patterns = [
            // Greetings
            '/^(hai|halo|hi|hello|pagi|siang|sore|malam)/' => function() {
                return "Halo! 👋 Saya AI Assistant untuk Sistem ISO. Saya bisa membantu Anda dengan:

📄 Informasi dokumen
👥 Data user
📊 Statistik sistem
❓ Pertanyaan umum

Silakan tanya apa saja!";
            },

            // Help
            '/(bantuan|help|bisa apa|fungsi)/' => function() {
                return "Saya bisa membantu Anda dengan:

**Informasi Dokumen:**
- Berapa dokumen yang menunggu approval?
- Dokumen apa yang sudah approved?
- Status dokumen [kode]?

**Data User:**
- Siapa user dari departemen [nama]?
- Berapa total user?
- User dengan role [role]?

**Statistik:**
- Berapa dokumen pending?
- Berapa dokumen approved?
- Departemen mana yang paling aktif?

Contoh: 'Berapa dokumen yang menunggu approval?'";
            },

            // Thank you
            '/(terima kasih|thanks|makasih)/' => function() {
                return "Sama-sama! 😊 Senang bisa membantu. Ada yang bisa saya bantu lagi?";
            },
        ];
    }

    /**
     * Match question patterns
     */
    private function matchPattern($question)
    {
        foreach ($this->patterns as $pattern => $callback) {
            if (preg_match($pattern, $question)) {
                return $callback();
            }
        }
        return null;
    }

    /**
     * Query database based on question
     */
    private function queryDatabase($question)
    {
        // Document queries
        if (preg_match('/(berapa|jumlah).*(dokumen|document).*(tunggu|pending|menunggu)/i', $question)) {
            return $this->getPendingDocuments();
        }

        if (preg_match('/(berapa|jumlah).*(dokumen|document).*(approve|disetujui)/i', $question)) {
            return $this->getApprovedDocuments();
        }

        if (preg_match('/(berapa|jumlah).*(dokumen|document).*(tolak|ditolak|reject)/i', $question)) {
            return $this->getRejectedDocuments();
        }

        if (preg_match('/(berapa|jumlah|total).*(dokumen|document)/i', $question)) {
            return $this->getTotalDocuments();
        }

        // User queries
        if (preg_match('/(berapa|jumlah|total).*(user|pengguna)/i', $question)) {
            return $this->getTotalUsers();
        }

        if (preg_match('/(siapa|user|pengguna).*(departemen|department)\s+(\w+)/i', $question, $matches)) {
            $dept = $matches[3] ?? '';
            return $this->getUsersByDepartment($dept);
        }

        if (preg_match('/(berapa|jumlah).*(user|pengguna).*(role|sebagai)\s+(\w+)/i', $question, $matches)) {
            $role = $matches[4] ?? '';
            return $this->getUsersByRole($role);
        }

        // Department queries
        if (preg_match('/(departemen|department).*(paling|terbanyak|aktif)/i', $question)) {
            return $this->getMostActiveDeployment();
        }

        // Document status by code
        if (preg_match('/(status|info).*(dokumen|document)\s+([A-Z0-9\-]+)/i', $question, $matches)) {
            $code = $matches[3] ?? '';
            return $this->getDocumentStatus($code);
        }

        // Latest documents
        if (preg_match('/(dokumen|document).*(terbaru|terakhir|latest)/i', $question)) {
            return $this->getLatestDocuments();
        }

        return null;
    }

    // ==================== DATABASE QUERY METHODS ====================

    private function getPendingDocuments()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM document_requests 
            WHERE status LIKE '%Menunggu%'
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        $stmt = $this->db->prepare("
            SELECT kode_dokumen, judul_baru, status, departemen
            FROM document_requests 
            WHERE status LIKE '%Menunggu%'
            ORDER BY created_at DESC
            LIMIT 5
        ");
        $stmt->execute();
        $docs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = "📋 **Dokumen yang menunggu approval:** $count dokumen\n\n";
        
        if ($count > 0) {
            $response .= "**5 Dokumen Terbaru:**\n";
            foreach ($docs as $doc) {
                $response .= "• **{$doc['kode_dokumen']}** - {$doc['judul_baru']}\n";
                $response .= "  Status: {$doc['status']} | Dept: {$doc['departemen']}\n\n";
            }
        } else {
            $response .= "✅ Tidak ada dokumen yang menunggu approval.";
        }

        return $response;
    }

    private function getApprovedDocuments()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM document_requests 
            WHERE status = 'Approved' OR status = 'Selesai'
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        return "✅ **Dokumen yang sudah approved:** $count dokumen\n\nDokumen yang sudah approved dapat dilihat di menu History Dokumen.";
    }

    private function getRejectedDocuments()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM document_requests 
            WHERE status LIKE '%Ditolak%'
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        return "❌ **Dokumen yang ditolak:** $count dokumen";
    }

    private function getTotalDocuments()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM document_requests");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $result['count'];

        // Breakdown by status
        $stmt = $this->db->prepare("
            SELECT 
                SUM(CASE WHEN status LIKE '%Menunggu%' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status IN ('Approved', 'Selesai') THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status LIKE '%Ditolak%' THEN 1 ELSE 0 END) as rejected
            FROM document_requests
        ");
        $stmt->execute();
        $breakdown = $stmt->fetch(PDO::FETCH_ASSOC);

        return "📊 **Total dokumen di sistem:** $total dokumen\n\n" .
               "**Breakdown:**\n" .
               "⏳ Menunggu: {$breakdown['pending']} dokumen\n" .
               "✅ Approved: {$breakdown['approved']} dokumen\n" .
               "❌ Ditolak: {$breakdown['rejected']} dokumen";
    }

    private function getTotalUsers()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $result['count'];

        // Breakdown by role
        $stmt = $this->db->prepare("
            SELECT 
                SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admin,
                SUM(CASE WHEN role = 'pic' THEN 1 ELSE 0 END) as pic,
                SUM(CASE WHEN role = 'hod' THEN 1 ELSE 0 END) as hod,
                SUM(CASE WHEN role = 'mr' THEN 1 ELSE 0 END) as mr,
                SUM(CASE WHEN role = 'gm' THEN 1 ELSE 0 END) as gm
            FROM users
        ");
        $stmt->execute();
        $breakdown = $stmt->fetch(PDO::FETCH_ASSOC);

        return "👥 **Total user di sistem:** $total user\n\n" .
               "**Breakdown by Role:**\n" .
               "👨‍💼 Admin: {$breakdown['admin']} user\n" .
               "👤 PIC: {$breakdown['pic']} user\n" .
               "👔 HOD: {$breakdown['hod']} user\n" .
               "📋 MR: {$breakdown['mr']} user\n" .
               "🎯 GM: {$breakdown['gm']} user";
    }

    private function getUsersByDepartment($dept)
    {
        $stmt = $this->db->prepare("
            SELECT nama, username, role 
            FROM users 
            WHERE LOWER(departemen) LIKE LOWER(?)
            ORDER BY nama
        ");
        $stmt->execute(["%$dept%"]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($users)) {
            return "Tidak ada user dari departemen \"$dept\".";
        }

        $response = "👥 **User dari departemen $dept:** " . count($users) . " user\n\n";
        foreach ($users as $user) {
            $response .= "• **{$user['nama']}** (@{$user['username']})\n";
            $response .= "  Role: " . strtoupper($user['role']) . "\n\n";
        }

        return $response;
    }

    private function getUsersByRole($role)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM users 
            WHERE LOWER(role) = LOWER(?)
        ");
        $stmt->execute([$role]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        $stmt = $this->db->prepare("
            SELECT nama, departemen 
            FROM users 
            WHERE LOWER(role) = LOWER(?)
            ORDER BY nama
            LIMIT 10
        ");
        $stmt->execute([$role]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = "👥 **User dengan role " . strtoupper($role) . ":** $count user\n\n";
        
        if ($count > 0) {
            foreach ($users as $user) {
                $response .= "• {$user['nama']} ({$user['departemen']})\n";
            }
            if ($count > 10) {
                $response .= "\n... dan " . ($count - 10) . " user lainnya";
            }
        }

        return $response;
    }

    private function getMostActiveDeployment()
    {
        $stmt = $this->db->prepare("
            SELECT departemen, COUNT(*) as count 
            FROM document_requests 
            GROUP BY departemen 
            ORDER BY count DESC 
            LIMIT 5
        ");
        $stmt->execute();
        $depts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($depts)) {
            return "Belum ada data dokumen per departemen.";
        }

        $response = "📊 **Departemen paling aktif:**\n\n";
        $rank = 1;
        foreach ($depts as $dept) {
            $medal = $rank == 1 ? '🥇' : ($rank == 2 ? '🥈' : ($rank == 3 ? '🥉' : '📍'));
            $response .= "$medal **{$dept['departemen']}**: {$dept['count']} dokumen\n";
            $rank++;
        }

        return $response;
    }

    private function getDocumentStatus($code)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM document_requests 
            WHERE kode_dokumen = ? 
            LIMIT 1
        ");
        $stmt->execute([$code]);
        $doc = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$doc) {
            return "❌ Dokumen dengan kode \"$code\" tidak ditemukan di sistem.";
        }

        $statusIcon = '⏳';
        if (strpos($doc['status'], 'Approved') !== false) $statusIcon = '✅';
        if (strpos($doc['status'], 'Ditolak') !== false) $statusIcon = '❌';

        return "📄 **Informasi Dokumen {$doc['kode_dokumen']}**\n\n" .
               "**Judul:** {$doc['judul_baru']}\n" .
               "**Departemen:** {$doc['departemen']}\n" .
               "**Status:** $statusIcon {$doc['status']}\n" .
               "**Jenis:** {$doc['jenis_pengajuan']}\n" .
               "**Versi:** {$doc['versi']}\n" .
               "**Dibuat:** " . date('d M Y', strtotime($doc['created_at']));
    }

    private function getLatestDocuments()
    {
        $stmt = $this->db->prepare("
            SELECT kode_dokumen, judul_baru, status, departemen, created_at
            FROM document_requests 
            ORDER BY created_at DESC 
            LIMIT 5
        ");
        $stmt->execute();
        $docs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($docs)) {
            return "Belum ada dokumen di sistem.";
        }

        $response = "📄 **5 Dokumen Terbaru:**\n\n";
        foreach ($docs as $doc) {
            $statusIcon = strpos($doc['status'], 'Menunggu') !== false ? '⏳' : 
                         (strpos($doc['status'], 'Approved') !== false ? '✅' : '❌');
            
            $response .= "$statusIcon **{$doc['kode_dokumen']}**\n";
            $response .= "   {$doc['judul_baru']}\n";
            $response .= "   {$doc['departemen']} • " . date('d M Y', strtotime($doc['created_at'])) . "\n\n";
        }

        return $response;
    }

    private function getFallbackResponse()
    {
        $responses = [
            "Maaf, saya belum mengerti pertanyaan itu. 😅\n\nCoba tanya seperti:\n• Berapa dokumen yang menunggu approval?\n• Siapa user dari departemen Engineering?\n• Status dokumen ISO-001?",
            
            "Hmm, saya belum bisa menjawab itu. 🤔\n\nSilakan tanya tentang:\n• Informasi dokumen\n• Data user\n• Statistik sistem",
            
            "Pertanyaan yang menarik! Tapi saya belum bisa jawab yang itu. 💡\n\nKetik 'bantuan' untuk lihat apa yang bisa saya bantu.",
        ];

        return $responses[array_rand($responses)];
    }
}
