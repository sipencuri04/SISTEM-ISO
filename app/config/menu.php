<?php

return [

    'admin' => [
        ['label' => 'Dashboard', 'icon' => '🏠', 'action' => 'dashboard'],
        ['label' => 'Manajemen User', 'icon' => '👤', 'action' => 'userIndex'],

        ['label' => 'Upload Dokumen', 'icon' => '📤', 'action' => 'uploadDocument'],
        ['label' => 'Daftar Dokumen', 'icon' => '📄', 'action' => 'documentList'],
        ['label' => 'Monitoring', 'icon' => '📊', 'action' => 'monitoring'],
        ['label' => 'Laporan', 'icon' => '📑', 'action' => 'report'],
    ],

    'pic' => [
        ['label' => 'Dashboard', 'icon' => '🏠', 'action' => 'dashboard'],
        ['label' => 'Upload Dokumen', 'icon' => '📤', 'action' => 'uploadDocument'],
        ['label' => 'Dokumen Saya', 'icon' => '📄', 'action' => 'documentList'],
    ],

    'hod' => [
        ['label' => 'Dashboard', 'icon' => '🏠', 'action' => 'dashboard'],
        ['label' => 'Approval Dokumen', 'icon' => '✅', 'action' => 'approval'],
        ['label' => 'Dokumen Departemen', 'icon' => '📄', 'action' => 'documentList'],
    ],

    // 🔥 TAMBAH MR → CUMA DI SINI
    'mr' => [
        ['label' => 'Dashboard', 'icon' => '🏠', 'action' => 'dashboard'],
        ['label' => 'Review Dokumen', 'icon' => '🧐', 'action' => 'approval'],
        ['label' => 'Monitoring ISO', 'icon' => '📊', 'action' => 'monitoring'],
        ['label' => 'Laporan ISO', 'icon' => '📑', 'action' => 'report'],
    ],

    // 🔥 TAMBAH GM → CUMA DI SINI
    'gm' => [
        ['label' => 'Dashboard', 'icon' => '🏠', 'action' => 'dashboard'],
        ['label' => 'Approval Final', 'icon' => '🧾', 'action' => 'approval'],
        ['label' => 'Ringkasan Laporan', 'icon' => '📊', 'action' => 'report'],
    ],

];
