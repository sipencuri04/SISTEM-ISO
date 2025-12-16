<?php

include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
// proteksi login PIC
if (!isset($_SESSION['user'])) {
    header('Location: index.php?action=login');
    exit;
}
?>
<div class="content">

    <h2>Pengajuan Dokumen ISO</h2>

    <form action="<?= BASE_URL ?>?controller=Document&action=store"
          method="POST"
          enctype="multipart/form-data"
          style="max-width:700px;background:#fff;padding:24px;border-radius:12px">

    <!-- JENIS PENGAJUAN -->
    <div style="margin-bottom:16px">
        <label>Jenis Pengajuan</label><br>
        <select name="jenis_pengajuan" required style="width:100%;padding:10px">
            <option value="">-- Pilih --</option>
            <option value="baru">Dokumen Baru</option>
            <option value="revisi">Revisi Dokumen</option>
            <option value="penghapusan">Penghapusan Dokumen</option>
        </select>
    </div>

    <!-- KODE -->
    <div style="margin-bottom:16px">
        <label>Kode Dokumen</label><br>
        <input type="text" name="kode_dokumen" required
               placeholder="Contoh: SOP-HR-001"
               style="width:100%;padding:10px">
    </div>

    <!-- NAMA -->
    <div style="margin-bottom:16px">
        <label>Nama Dokumen</label><br>
        <input type="text" name="nama_dokumen" required
               placeholder="Contoh: SOP Rekrutmen"
               style="width:100%;padding:10px">
    </div>

    <!-- JENIS DOKUMEN -->
    <div style="margin-bottom:16px">
        <label>Jenis Dokumen</label><br>
        <select name="jenis_dokumen" required style="width:100%;padding:10px">
            <option value="">-- Pilih --</option>
            <option value="SOP">SOP</option>
            <option value="WI">Work Instruction</option>
            <option value="FORM">Form</option>
            <option value="POLICY">Policy</option>
        </select>
    </div>

    <!-- ALASAN -->
    <div style="margin-bottom:16px">
        <label>Alasan Pengajuan</label><br>
        <textarea name="alasan" rows="4" required
                  style="width:100%;padding:10px"></textarea>
    </div>

    <!-- DESKRIPSI PERUBAHAN -->
    <div style="margin-bottom:16px">
        <label>Deskripsi Perubahan (jika revisi)</label><br>
        <textarea name="deskripsi_perubahan" rows="3"
                  style="width:100%;padding:10px"></textarea>
    </div>

    <!-- FILE -->
    <div style="margin-bottom:20px">
        <label>Upload Dokumen (PDF / DOCX)</label><br>
        <input type="file" name="file_dokumen"
               accept=".pdf,.doc,.docx" required>
    </div>

    <button type="submit"
            style="background:#2563eb;color:#fff;
                   padding:12px 20px;border:none;border-radius:8px">
        Submit Pengajuan
    </button>
</div>
    <a href="index.php?action=document_list"
       style="margin-left:12px">Batal</a>
</form>
