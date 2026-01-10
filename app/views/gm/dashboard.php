<?php
$pageTitle = 'Dashboard GM';
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';

// Default values if not set
$statusLabel = $statusLabel ?? ['Menunggu','Disahkan','Ditolak'];
$statusData = $statusData ?? [$pending ?? 0, $approved ?? 0, $rejected ?? 0];
$monthLabel = $monthLabel ?? [];
$monthData = $monthData ?? [];
?>

<div class="content">
    <h2>📊 Dashboard GM</h2>
    <p>Ringkasan status pengesahan dokumen ISO</p>

    <!-- KPI -->
    <div class="grid grid-3 mb-4">
        <div class="card yellow">
            <h3>Menunggu Pengesahan</h3>
            <p><?= $pending ?? 0 ?></p>
        </div>
        <div class="card green">
            <h3>Disahkan</h3>
            <p><?= $approved ?? 0 ?></p>
        </div>
        <div class="card red">
            <h3>Ditolak</h3>
            <p><?= $rejected ?? 0 ?></p>
        </div>
    </div>

    <!-- CHART -->
    <div class="grid grid-2">
        <div class="chart-box">
            <h4>Status Dokumen</h4>
            <canvas id="statusChart"></canvas>
        </div>

        <div class="chart-box">
            <h4>Tren Pengesahan per Bulan</h4>
            <canvas id="trendChart"></canvas>
        </div>
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
            backgroundColor: ['#facc15','#22c55e','#ef4444']
        }]
    },
    options:{
        plugins:{legend:{position:'bottom'}}
    }
});

new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($monthLabel) ?>,
        datasets: [{
            label: 'Dokumen Disahkan',
            data: <?= json_encode($monthData) ?>,
            borderColor: '#22c55e',
            tension: 0.4,
            fill: false
        }]
    },
    options:{
        plugins:{legend:{display:false}},
        scales:{
            y:{beginAtZero:true}
        }
    }
});
</script>

<?php include BASE_PATH . '/app/views/gm/layout/footer.php'; ?>
