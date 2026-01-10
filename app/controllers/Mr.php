<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class Mr
{
    private $model;

    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'mr') {
            header("Location: " . BASE_URL_INDEX . "?controller=Auth&action=login");
            exit;
        }

        $this->model = new M_DocumentRequest();
    }

    // list dokumen untuk MR
    public function index()
    {
        $documents = $this->model->getPendingMr();
        include BASE_PATH . '/app/views/mr/document/index.php';
    }

    // detail dokumen
    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak valid');

        $document = $this->model->getById($id);
        if (!$document) die('Dokumen tidak ditemukan');

        include BASE_PATH . '/app/views/mr/document/show.php';
    }

    // approve MR
    public function approve()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak valid');

        $this->model->updateStatus($id, 'Menunggu Pengesahan GM');

        header("Location: " . BASE_URL_INDEX . "?controller=Mr&action=index");
        exit;
    }

    // reject MR
    public function reject()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die('ID tidak valid');

        $this->model->updateStatus($id, 'Ditolak MR');

        header("Location: " . BASE_URL_INDEX . "?controller=Mr&action=index");
        exit;
    }
}
