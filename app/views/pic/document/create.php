<?php
include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php?controller=Auth&action=login');
    exit;
}
?>

<div class="content">
<h2>Form Usulan Perubahan Dokumen ISO</h2>

<form action="<?= BASE_URL_INDEX ?>?controller=Document&action=store"
      method="POST"
      enctype="multipart/form-data"
      style="max-width:800px;background:#fff;padding:24px;border-radius:12px">

<!-- ================= INFORMASI UMUM ================= -->
<div style="margin-bottom:16px">
    <label>Tanggal Pengajuan</label>
    <input type="text" value="<?= date('d-m-Y') ?>" readonly
           style="width:100%;padding:10px;background:#f3f4f6">
</div>

<div style="margin-bottom:16px">
    <label>Departemen</label>
    <input type="text" value="<?= $_SESSION['user']['departemen'] ?>" readonly
           style="width:100%;padding:10px;background:#f3f4f6">
</div>

<!-- ================= JENIS PERUBAHAN ================= -->
<div style="margin-bottom:16px">
    <label>Jenis Perubahan</label><br>
    <label><input type="checkbox" name="jenis_dokumen[]" value="Pedoman Mutu"> Pedoman Mutu</label><br>
    <label><input type="checkbox" name="jenis_dokumen[]" value="Prosedur"> Prosedur</label><br>
    <label><input type="checkbox" name="jenis_dokumen[]" value="Instruksi Kerja"> Instruksi Kerja</label><br>
    <label><input type="checkbox" name="jenis_dokumen[]" value="Formulir"> Formulir</label><br>
</div>

<!-- ================= JENIS PENGAJUAN ================= -->
<div style="margin-bottom:16px">
    <label>Perubahan yang Diminta</label><br>
    <select name="jenis_pengajuan" required style="width:100%;padding:10px">
        <option value="">-- Pilih --</option>
        <option value="baru">Dokumen Baru</option>
        <option value="revisi">Revisi Dokumen</option>
        <option value="penghapusan">Penghapusan Dokumen</option>
    </select>
</div>

<!-- ================= DOKUMEN ================= -->
<div style="margin-bottom:16px">
    <label>Kode Dokumen</label>
    <input type="text" name="kode_dokumen" required
           placeholder="FRM-ENG-021"
           style="width:100%;padding:10px">
</div>

<div style="margin-bottom:16px">
    <label>Nama Dokumen</label>
    <input type="text" name="nama_dokumen" required
           placeholder="Schedule Maintenance AC Split"
           style="width:100%;padding:10px">
</div>

<!-- ================= RIWAYAT REVISI ================= -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
    <div>
        <label>No Revisi Lama</label>
        <input type="text" name="revisi_lama" placeholder="00"
               style="width:100%;padding:10px">
    </div>
    <div>
        <label>No Revisi Baru</label>
        <input type="text" name="versi" placeholder="01"
               style="width:100%;padding:10px">
    </div>
</div>

<!-- ================= JUDUL DOKUMEN ================= -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
    <div>
        <label>Judul Dokumen Lama</label>
        <input type="text" name="judul_lama"
               placeholder="Judul dokumen sebelum revisi"
               style="width:100%;padding:10px">
    </div>
    <div>
        <label>Judul Dokumen Baru</label>
        <input type="text" name="judul_baru"
               placeholder="Judul dokumen setelah revisi"
               style="width:100%;padding:10px">
    </div>
</div>

<!-- ================= URAIAN ================= -->
<div style="margin-bottom:16px">
    <label>Uraian Usulan Perubahan</label>
    <textarea name="deskripsi_perubahan" rows="4"
              style="width:100%;padding:10px"></textarea>
</div>

<div style="margin-bottom:16px">
    <label>Dampak Perubahan</label>
    <textarea name="dampak_perubahan" rows="3"
              style="width:100%;padding:10px"></textarea>
</div>

<!-- ================= JADWAL ================= -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
    <div>
        <label>Rencana Pelaksanaan</label>
        <input type="date" name="tanggal_rencana"
               style="width:100%;padding:10px">
    </div>
    <div>
        <label>Realisasi Pelaksanaan</label>
        <input type="date" name="tanggal_realisasi"
               style="width:100%;padding:10px">
    </div>
</div>

<!-- ================= FILE ================= -->
<div style="
    margin-bottom:24px;
    padding:16px;
    border:2px dashed #cbd5e1;
    border-radius:12px;
    background:#f8fafc;
">

    <label style="display:block;margin-bottom:10px">
        <strong>Upload Dokumen (PDF / DOCX)</strong><br>
        <small style="color:#64748b">
            Dokumen yang dilampirkan sebagai usulan atau revisi
            dan akan digunakan sebagai bahan review serta approval.
        </small>
    </label>

    <input type="file" name="file_dokumen"
           accept=".pdf,.doc,.docx"
           required
           style="
               padding:10px;
               background:#fff;
               border:1px solid #e5e7eb;
               border-radius:8px;
               width:100%;
           ">

</div>


<button type="submit"
        style="background:#2563eb;color:#fff;
               padding:12px 20px;border:none;border-radius:8px">
    Submit Pengajuan
</button>

<a href="<?= BASE_URL_INDEX ?>?controller=Dashboard&action=index"
   style="margin-left:12px">Batal</a>

</form>
</div>
