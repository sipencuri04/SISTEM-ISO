<?php
require_once BASE_PATH . '/app/models/M_DocumentRequest.php';

class Document
{
    private $model;

    public function __construct()
    {
        $this->model = new M_DocumentRequest();
    }

    /* tampil form */
    public function create()
    {
        include BASE_PATH . '/app/views/pic/document/create.php';
    }

    /* simpan data */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Akses tidak valid');
        }

        $jenis_pengajuan = $_POST['jenis_pengajuan'] ?? '';
        $kode_dokumen    = $_POST['kode_dokumen'] ?? '';
        $nama_dokumen    = $_POST['nama_dokumen'] ?? '';
        $jenis_dokumen   = $_POST['jenis_dokumen'] ?? '';
        $alasan          = $_POST['alasan'] ?? '';
        $deskripsi       = $_POST['deskripsi_perubahan'] ?? '';

        if (!$jenis_pengajuan || !$kode_dokumen || !$nama_dokumen || !$jenis_dokumen || !$alasan) {
            die('Form tidak lengkap');
        }

        if ($jenis_pengajuan === 'revisi' && empty($deskripsi)) {
            die('Deskripsi perubahan wajib diisi');
        }

        if (!isset($_FILES['file_dokumen'])) {
            die('File tidak ditemukan');
        }

        $file = $_FILES['file_dokumen'];
        $folder = BASE_PATH . '/public/uploads/documents/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $folder . $filename);

        $this->model->insert([
            'user_id' => $_SESSION['user']['id'],
            'departemen' => $_SESSION['user']['departemen'],
            'jenis_pengajuan' => $jenis_pengajuan,
            'kode_dokumen' => $kode_dokumen,
            'nama_dokumen' => $nama_dokumen,
            'jenis_dokumen' => $jenis_dokumen,
            'alasan' => $alasan,
            'deskripsi_perubahan' => $deskripsi,
            'file_path' => 'uploads/documents/' . $filename
        ]);

        header("Location: " . BASE_URL . "?controller=Document&action=index");
        exit;
    }

    /* list */
    public function index()
    {
        $documents = $this->model->getByUser($_SESSION['user']['id']);
        include BASE_PATH . '/app/views/pic/document/index.php';
    }

  

   
}
