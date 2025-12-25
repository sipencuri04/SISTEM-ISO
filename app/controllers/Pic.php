<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class Pic
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pic') {
            header("Location: " . BASE_URL . "?controller=Auth&action=login");
            exit;
        }

        $this->model = new M_DocumentRequest();
    }

    // Arsip Dokumen yang sudah disetujui GM
    public function archive()
    {
        $departemen = $_SESSION['user']['departemen'];
        
        // Ambil dokumen 'Disetujui' sesuai departemen
        $documents = $this->model->getApprovedByDepartemen($departemen);

        include BASE_PATH . '/app/views/pic/document/archive.php';
    }
}
