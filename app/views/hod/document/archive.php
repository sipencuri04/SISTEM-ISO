<?php include BASE_PATH . '/app/views/hod/layout/sidebar.php'; ?>

<div class="content">
    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1e293b; margin:0;">📂 Arsip Dokumen Disetujui (HOD)</h1>
            <p style="color:#64748b; margin:5px 0 0;">Daftar dokumen department yang telah disahkan oleh General Manager (GM)</p>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div style="background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.02); padding:24px; border:1px solid #e2e8f0;">
        
        <?php if (empty($documents)): ?>
            <div style="text-align:center; padding:50px 0; color:#cbd5e1;">
                <span class="icon" style="font-size:48px; display:block; margin-bottom:10px;">📭</span>
                <p>Belum ada dokumen yang disahkan saat ini.</p>
            </div>
        <?php else: ?>
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:2px solid #f1f5f9; text-align:left;">
                        <th style="padding:15px; color:#64748b; font-size:12px; text-transform:uppercase;">Kode</th>
                        <th style="padding:15px; color:#64748b; font-size:12px; text-transform:uppercase;">Judul Dokumen</th>
                        <th style="padding:15px; color:#64748b; font-size:12px; text-transform:uppercase;">Versi</th>
                        <th style="padding:15px; color:#64748b; font-size:12px; text-transform:uppercase;">Tanggal Sah</th>
                        <th style="padding:15px; color:#64748b; font-size:12px; text-transform:uppercase; text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr style="border-bottom:1px solid #f1f5f9; transition:background .2s;">
                            <td style="padding:15px; font-weight:600; color:#4F46E5;">
                                <?= htmlspecialchars($doc['kode_dokumen']) ?>
                            </td>
                            <td style="padding:15px;">
                                <div style="font-weight:600; color:#1e293b;">
                                    <?= htmlspecialchars($doc['judul_baru']) ?>
                                </div>
                                <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                                    <?= htmlspecialchars($doc['jenis_dokumen']) ?>
                                </div>
                            </td>
                            <td style="padding:15px;">
                                <span style="background:#f0f9ff; color:#0369a1; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                                    <?= htmlspecialchars($doc['versi']) ?>
                                </span>
                            </td>
                            <td style="padding:15px; color:#64748b; font-size:14px;">
                                <?= date('d M Y', strtotime($doc['updated_at'] ?? $doc['created_at'])) ?>
                            </td>
                            <td style="padding:15px; text-align:right;">
                                <?php
                                // Fix URL parsing
                                $baseUrl = str_replace('/index.php', '', BASE_URL);
                                $fileUrl = $baseUrl . '/' . $doc['file_path'];
                                
                                // Check physical file existence
                                $localAbsPath = BASE_PATH . '/public/' . $doc['file_path'];
                                $fileExists = file_exists($localAbsPath);
                                ?>
                                
                                <?php if ($fileExists): ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" 
                                       style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e2e8f0; padding:8px 16px; border-radius:8px; text-decoration:none; color:#1e293b; font-size:13px; font-weight:600; transition:.2s;">
                                        <span>👁️</span> Lihat
                                    </a>
                                    <a href="<?= $fileUrl ?>" download
                                       style="display:inline-flex; align-items:center; gap:6px; background:#4F46E5; color:white; padding:8px 16px; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; margin-left:5px; transition:.2s;">
                                        <span>⬇</span> Unduh
                                    </a>
                                <?php else: ?>
                                    <span style="background:#fee2e2; color:#991b1b; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:600; border:1px solid #fca5a5;">
                                        ⚠️ File Hilang
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

</div>

<style>
    tr:hover { background-color: #f8fafc; }
    a:hover { opacity: 0.9; transform: translateY(-1px); }
</style>
