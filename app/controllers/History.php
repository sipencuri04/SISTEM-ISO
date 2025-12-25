<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class History {

    private $model;

    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASE_URL . "?controller=Auth&action=login");
            exit;
        }

        $this->model = new M_DocumentRequest();
    }

    public function index() {
        $documents = $this->model->getMonitoring(); // Reuse existing monitoring query which gets all history
        include BASE_PATH . '/app/views/admin/history/index.php';
    }
}
