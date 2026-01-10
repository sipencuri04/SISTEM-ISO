<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class Admin
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL_INDEX . "?controller=Auth&action=login");
            exit;
        }

        $this->model = new M_DocumentRequest();
    }

    public function index()
    {
        $documents = $this->model->getPendingAdmin();
        include BASE_PATH . '/app/views/admin/document/index.php';
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die('ID tidak valid');
        }

        $document = $this->model->getById($id);
        if (!$document) {
            die('Dokumen tidak ditemukan');
        }

        include BASE_PATH . '/app/views/admin/document/show.php';
    }

    public function approve()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die('ID tidak valid');
        }

        $this->model->updateStatus($id, 'Menunggu Review MR');

        header("Location: " . BASE_URL_INDEX . "?controller=Admin&action=index");
        exit;
    }

    public function reject()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            die('ID tidak valid');
        }

        $this->model->updateStatus($id, 'Ditolak Admin');

        header("Location: " . BASE_URL_INDEX . "?controller=Admin&action=index");
        exit;
    }
}
