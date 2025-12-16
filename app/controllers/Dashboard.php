<?php
class Dashboard {

    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }

        $role = $_SESSION['user']['role'];

        if ($role === 'admin') {
            require_once BASE_PATH . '/app/models/M_DocumentRequest.php';
            $doc = new M_DocumentRequest();

            // DATA UNTUK DASHBOARD
            $status     = $doc->countByStatus();
            $departemen = $doc->countByDepartemen();
            $perbulan   = $doc->countPerMonth();
        }

        $map = [
            'admin' => 'admin',
            'pic'   => 'pic',
            'hod'   => 'hod',
            'mr'    => 'mr',
            'gm'    => 'gm'
        ];

        $folder = $map[$role] ?? 'admin';
        $view   = BASE_PATH . "/app/views/{$folder}/dashboard.php";

        if (!file_exists($view)) {
            die("Dashboard role {$role} tidak ditemukan");
        }

        // VARIABEL ($status, $departemen, $perbulan)
        // otomatis terbaca di VIEW admin/dashboard.php
        include $view;
    }
}
