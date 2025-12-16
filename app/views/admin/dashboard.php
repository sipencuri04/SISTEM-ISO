<?php
include '../app/views/admin/layout/header.php';
include '../app/views/admin/layout/sidebar.php';

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

<style>
.content{padding:24px;background:#f1f5f9;min-height:100vh;font-family:system-ui}
.kpi{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin:24px 0}
.card{background:#fff;padding:20px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,.06);text-align:center}
.card h3{font-size:14px;color:#6b7280;margin-bottom:6px}
.card p{font-size:28px;font-weight:700;margin:0}
.green{border-top:4px solid #22c55e}
.blue{border-top:4px solid #3b82f6}
.yellow{border-top:4px solid #facc15}
.red{border-top:4px solid #ef4444}
.chart-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.chart-box{background:#fff;padding:20px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
</style>

<div class="content">
    <h2>Dashboard Admin ISO</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>

    <!-- KPI -->
    <div class="kpi">
        <div class="card green">
            <h3>Total Pengajuan</h3>
            <p><?= array_sum($statusData) ?></p>
        </div>

        <div class="card blue">
            <h3>Approved</h3>
            <p><?= $statusData[array_search('Approved', $statusLabel)] ?? 0 ?></p>
        </div>

        <div class="card yellow">
            <h3>Pending</h3>
            <p><?= $statusData[array_search('Menunggu Approval HOD', $statusLabel)] ?? 0 ?></p>
        </div>

        <div class="card red">
            <h3>Rejected</h3>
            <p><?= $statusData[array_search('Rejected', $statusLabel)] ?? 0 ?></p>
        </div>
    </div>

    <!-- CHART -->
    <div class="chart-grid">
        <div class="chart-box">
            <h4>Status Dokumen</h4>
            <canvas id="statusChart"></canvas>
        </div>

        <div class="chart-box">
            <h4>Dokumen per Departemen</h4>
            <canvas id="deptChart"></canvas>
        </div>
    </div>

    <div class="chart-box" style="margin-top:30px">
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
            fill: false
        }]
    }
});
</script>

<?php include '../app/views/admin/layout/footer.php'; ?>
