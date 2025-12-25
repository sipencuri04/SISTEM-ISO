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

    // ================= DATA WAJIB =================
    $jenis_pengajuan = $_POST['jenis_pengajuan'] ?? '';
    $kode_dokumen    = $_POST['kode_dokumen'] ?? '';
    $nama_dokumen    = $_POST['nama_dokumen'] ?? '';

    // checkbox → array → string
    $jenis_dokumen = isset($_POST['jenis_dokumen'])
        ? implode(', ', $_POST['jenis_dokumen'])
        : '';

    // ALASAN = DESKRIPSI PERUBAHAN (FIX UTAMA)
    $alasan = $_POST['deskripsi_perubahan'] ?? '';

    if (!$jenis_pengajuan || !$kode_dokumen || !$nama_dokumen || !$jenis_dokumen || !$alasan) {
        die('Form tidak lengkap');
    }

    // ================= DATA TAMBAHAN ISO =================
    $deskripsi       = $_POST['deskripsi_perubahan'] ?? null;
    $revisi_lama     = $_POST['revisi_lama'] ?? null;
    $versi           = $_POST['versi'] ?? 'Rev.00';
    $judul_lama      = $_POST['judul_lama'] ?? null;
    $judul_baru      = $_POST['judul_baru'] ?? $nama_dokumen;
    $dampak          = $_POST['dampak_perubahan'] ?? null;
    $tgl_rencana     = $_POST['tanggal_rencana'] ?? null;
    $tgl_realisasi   = $_POST['tanggal_realisasi'] ?? null;

    if ($jenis_pengajuan === 'revisi' && empty($deskripsi)) {
        die('Deskripsi perubahan wajib diisi untuk revisi');
    }

    // ================= FILE UPLOAD =================
    if (!isset($_FILES['file_dokumen']) || $_FILES['file_dokumen']['error'] !== 0) {
        die('File tidak valid');
    }

    $file = $_FILES['file_dokumen'];
    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['pdf','doc','docx'])) {
        die('Format file harus PDF / DOC / DOCX');
    }

    $folder = BASE_PATH . '/public/uploads/documents/';
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/','',$file['name']);
    move_uploaded_file($file['tmp_name'], $folder . $filename);

    // ================= SIMPAN KE DATABASE =================
    $this->model->insert([
        'user_id'              => $_SESSION['user']['id'],
        'departemen'           => $_SESSION['user']['departemen'],
        'jenis_pengajuan'      => $jenis_pengajuan,
        'kode_dokumen'         => $kode_dokumen,
        'nama_dokumen'         => $judul_baru,
        'jenis_dokumen'        => $jenis_dokumen,
        'alasan'               => $alasan,
        'deskripsi_perubahan'  => $deskripsi,
        'revisi_lama'          => $revisi_lama,
        'versi'                => $versi,
        'judul_lama'           => $judul_lama,
        'judul_baru'           => $judul_baru,
        'dampak_perubahan'     => $dampak,
        'tanggal_rencana'      => $tgl_rencana,
        'tanggal_realisasi'    => $tgl_realisasi,
        'status'               => 'Menunggu Approval HOD',
        'is_active'            => 0,
        'file_path'            => 'uploads/documents/' . $filename
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
// <?php
// // config.php — sesuaikan credential database Anda
// return [
//     'db' => [
//         'host' => 'localhost',
//         'dbname' => 'u1575962_kalkulator_hk',  
//         'user' => 'u1575962_app',
//         'pass' => 'gahc2025',
//         'charset' => 'utf8mb4'
//     ]
// ];


