<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class Hod
{
    private $model;

    public function __construct()
    {
        // proteksi role HOD
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'hod') {
            header("Location: " . BASE_URL_INDEX . "?controller=Auth&action=login");
            exit;
        }

        $this->model = new M_DocumentRequest();
    }

    // list pengajuan masuk
    public function index()
    {
        $departemen = $_SESSION['user']['departemen'];

        $documents = $this->model->getPendingHod($departemen);

        include BASE_PATH . '/app/views/hod/document/index.php';
    }

    // approve
    public function approve()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak valid');

        $this->model->updateStatus(
            $id,
            'Menunggu Validasi Admin'
        );

        header("Location: " . BASE_URL_INDEX . "?controller=Hod&action=index");
        exit;
    }

    // reject
    public function reject()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak valid');

        $this->model->updateStatus(
            $id,
            'Ditolak HOD'
        );

        header("Location: " . BASE_URL_INDEX . "?controller=Hod&action=index");
        exit;
    }

    // Arsip Dokumen Department
    public function archive()
    {
        $departemen = $_SESSION['user']['departemen'];
        $documents = $this->model->getApprovedByDepartemen($departemen);
        include BASE_PATH . '/app/views/hod/document/archive.php';
    }

    public function show()
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'hod') {
        header("Location: " . BASE_URL_INDEX . "?controller=Auth&action=login");
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die('ID tidak valid');
    }

    $document = $this->model->getById($id);
    if (!$document) {
        die('Dokumen tidak ditemukan');
    }

    include BASE_PATH . '/app/views/hod/document/show.php';
}

}
