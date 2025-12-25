<?php

class M_DocumentRequest
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function insert($data)
{
    $sql = "INSERT INTO document_requests (
        user_id,
        departemen,
        jenis_pengajuan,
        kode_dokumen,
        nama_dokumen,
        jenis_dokumen,
        alasan,
        deskripsi_perubahan,
        revisi_lama,
        versi,
        judul_lama,
        judul_baru,
        dampak_perubahan,
        tanggal_rencana,
        tanggal_realisasi,
        status,
        is_active,
        file_path
    ) VALUES (
        :user_id,
        :departemen,
        :jenis_pengajuan,
        :kode_dokumen,
        :nama_dokumen,
        :jenis_dokumen,
        :alasan,
        :deskripsi_perubahan,
        :revisi_lama,
        :versi,
        :judul_lama,
        :judul_baru,
        :dampak_perubahan,
        :tanggal_rencana,
        :tanggal_realisasi,
        :status,
        :is_active,
        :file_path
    )";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute($data);
}


    public function getByUser($user_id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM document_requests WHERE user_id = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingHod($departemen)
{
    $stmt = $this->db->prepare(
        "SELECT * FROM document_requests
         WHERE departemen = ?
         AND status = 'Menunggu Approval HOD'
         ORDER BY created_at DESC"
    );
    $stmt->execute([$departemen]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPendingAdmin()
{
    $stmt = $this->db->prepare(
        "SELECT * FROM document_requests
         WHERE status = 'Menunggu Validasi Admin'
         ORDER BY created_at DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPendingMr()
{
    $stmt = $this->db->prepare(
        "SELECT * FROM document_requests
         WHERE status = 'Menunggu Review MR'
         ORDER BY created_at DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ================== GM ==================
    public function getPendingGm()
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM document_requests
             WHERE status = 'Menunggu Pengesahan GM'
             ORDER BY created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================== APPROVED / ARCHIVE ==================
    public function getApprovedByDepartemen($departemen)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM document_requests
             WHERE departemen = ?
             AND status = 'Disetujui'
             ORDER BY created_at DESC"
        );
        $stmt->execute([$departemen]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




public function updateStatus($id, $status)
{
    $stmt = $this->db->prepare(
        "UPDATE document_requests
         SET status = ?
         WHERE id = ?"
    );
    return $stmt->execute([$status, $id]);
}

public function getById($id)
{
    $stmt = $this->db->prepare(
        "SELECT * FROM document_requests WHERE id = ?"
    );
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function countByStatus()
    {
        $sql = "
            SELECT status, COUNT(*) AS total
            FROM document_requests
            GROUP BY status
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByDepartemen()
    {
        $sql = "
            SELECT departemen, COUNT(*) AS total
            FROM document_requests
            GROUP BY departemen
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPerMonth()
    {
        $sql = "
            SELECT MONTH(created_at) AS bulan, COUNT(*) AS total
            FROM document_requests
            GROUP BY MONTH(created_at)
            ORDER BY bulan
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonitoring()
{
    $sql = "
        SELECT 
            dr.id,
            dr.kode_dokumen,
            dr.judul_lama,
            dr.judul_baru,
            dr.revisi_lama,
            dr.versi,
            dr.jenis_pengajuan,
            dr.jenis_dokumen,
            dr.departemen,
            dr.status,
            dr.created_at,
            u.nama AS pengaju
        FROM document_requests dr
        JOIN users u ON dr.user_id = u.id
        ORDER BY dr.created_at DESC
    ";
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


}


