<?php
$pageTitle = 'Dashboard Admin';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';

/* ================= STATUS ================= */
$statusLabel = [];
$statusData  = [];

if (!empty($status)) {
    foreach ($status as $s) {
        $statusLabel[] = $s['status'];
        $statusData[]  = (int)$s['total'];
    }
}

/* ================= DEPARTEMEN ================= */
$deptLabel = [];
$deptData  = [];

if (!empty($departemen)) {
    foreach ($departemen as $d) {
        $deptLabel[] = $d['departemen'];
        $deptData[]  = (int)$d['total'];
    }
}

/* ================= BULAN ================= */
$monthLabel = [];
$monthData  = [];

if (!empty($perbulan)) {
    foreach ($perbulan as $m) {
        $monthLabel[] = date('F', mktime(0,0,0,$m['bulan'],1));
        $monthData[]  = (int)$m['total'];
    }
}
?>

<div class="content">
    <h2>📊 Dashboard Admin ISO</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>

    <!-- KPI -->
    <div class="grid grid-4 mb-4">
        <div class="card green">
            <h3>Total Pengajuan</h3>
            <p><?= array_sum($statusData) ?></p>
        </div>

        <div class="card blue">
            <h3>Approved</h3>
            <p><?= $statusData[array_search('Disetujui', $statusLabel)] ?? 0 ?></p>
        </div>

        <div class="card yellow">
            <h3>Pending</h3>
            <p><?= $statusData[array_search('Menunggu Approval HOD', $statusLabel)] ?? 0 ?></p>
        </div>

        <div class="card red">
            <h3>Rejected</h3>
            <p><?= $statusData[array_search('Ditolak', $statusLabel)] ?? 0 ?></p>
        </div>
    </div>

    <!-- CHART -->
    <div class="grid grid-2 mb-4">
        <div class="chart-box">
            <h4>Status Dokumen</h4>
            <canvas id="statusChart"></canvas>
        </div>

        <div class="chart-box">
            <h4>Dokumen per Departemen</h4>
            <canvas id="deptChart"></canvas>
        </div>
    </div>

    <div class="chart-box">
        <h4>Pengajuan Dokumen per Bulan</h4>
        <canvas id="monthChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($statusLabel) ?>,
        datasets: [{
            data: <?= json_encode($statusData) ?>,
            backgroundColor: ['#22c55e','#facc15','#ef4444','#3b82f6']
        }]
    },
    options:{
        plugins:{legend:{position:'bottom'}}
    }
});

new Chart(document.getElementById('deptChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($deptLabel) ?>,
        datasets: [{
            label: 'Jumlah Dokumen',
            data: <?= json_encode($deptData) ?>,
            backgroundColor: '#3b82f6'
        }]
    }
});

new Chart(document.getElementById('monthChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($monthLabel) ?>,
        datasets: [{
            label: 'Pengajuan',
            data: <?= json_encode($monthData) ?>,
            borderColor: '#22c55e',
            tension: 0.4,
            fill: false
        }]
    },
    options:{
        scales:{
            y:{beginAtZero:true}
        }
    }
});
</script>

<?php include BASE_PATH . '/app/views/admin/layout/footer.php'; ?>
