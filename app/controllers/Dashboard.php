<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class Dashboard {

    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL_INDEX . "?controller=Auth&action=login");
            exit;
        }

        $role = $_SESSION['user']['role'];
        $doc = new M_DocumentRequest();

        // DATA BERDASARKAN ROLE
        switch ($role) {
            case 'admin':
                $status     = $doc->countByStatus();
                $departemen = $doc->countByDepartemen();
                $perbulan   = $doc->countPerMonth();
                break;

            case 'pic':
                $userId = $_SESSION['user']['id'];
                $allDocs = $doc->getByUser($userId);
                
                $total = count($allDocs);
                $pending = 0;
                $approved = 0;
                $rejected = 0;
                
                foreach ($allDocs as $d) {
                    if (str_contains($d['status'], 'Menunggu')) {
                        $pending++;
                    } elseif ($d['status'] === 'Disetujui') {
                        $approved++;
                    } elseif (str_contains($d['status'], 'Ditolak')) {
                        $rejected++;
                    }
                }
                break;

            case 'hod':
                $departemen = $_SESSION['user']['departemen'];
                $allDocs = $doc->getPendingHod($departemen);
                
                $total = count($allDocs);
                $pending = 0;
                $approved = 0;
                
                foreach ($allDocs as $d) {
                    if (str_contains($d['status'], 'Menunggu')) {
                        $pending++;
                    } else {
                        $approved++;
                    }
                }
                break;

            case 'mr':
                $allDocs = $doc->getPendingMr();
                $pending = count($allDocs);
                $reviewed = 0; // Bisa ditambahkan logic untuk dokumen yang sudah direview
                $toGm = 0; // Bisa ditambahkan logic untuk dokumen yang diteruskan ke GM
                break;

            case 'gm':
                $allDocs = $doc->getPendingGm();
                $pending = count($allDocs);
                $approved = 0; // Count dari status 'Disetujui'
                $rejected = 0; // Count dari status 'Ditolak GM'
                
                // Bisa ditambahkan query untuk menghitung approved dan rejected
                $statusLabel = ['Menunggu', 'Disahkan', 'Ditolak'];
                $statusData = [$pending, $approved, $rejected];
                
                // Data untuk chart trend (dummy data - bisa diganti dengan query real)
                $monthLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
                $monthData = [5, 8, 12, 7, 15, 10];
                break;
        }

        // MAPPING KE VIEW
        $viewMap = [
            'admin' => 'admin',
            'pic'   => 'pic',
            'hod'   => 'hod',
            'mr'    => 'mr',
            'gm'    => 'gm'
        ];

        $folder = $viewMap[$role] ?? 'admin';
        $view   = BASE_PATH . "/app/views/{$folder}/dashboard.php";

        if (!file_exists($view)) {
            die("Dashboard untuk role {$role} tidak ditemukan");
        }

        include $view;
    }
}
