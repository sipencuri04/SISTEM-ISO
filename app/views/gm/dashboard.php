<?php
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';

/*
Asumsi data dari controller:
$pending
$approved
$rejected

$statusLabel = ['Menunggu','Disahkan','Ditolak'];
$statusData  = [$pending, $approved, $rejected];

$monthLabel = ['Jan','Feb','Mar','Apr','Mei','Jun'];
$monthData  = $trend ?? [0,0,0,0,0,0];
*/
?>

<style>
.content{
    padding:24px;
    background:#f1f5f9;
    min-height:100vh;
    font-family:system-ui, -apple-system, BlinkMacSystemFont;
}

.grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:16px;
    margin-bottom:24px;
}

.card{
    background:#fff;
    padding:20px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
}

.card h3{
    font-size:14px;
    color:#64748b;
    margin:0;
}

.card p{
    font-size:28px;
    font-weight:700;
    margin-top:8px;
}

.green{border-top:4px solid #22c55e}
.yellow{border-top:4px solid #facc15}
.red{border-top:4px solid #ef4444}

.chart-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.chart-box{
    background:#fff;
    padding:20px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
}

.chart-box h4{
    margin:0 0 12px;
    font-size:16px;
}
</style>

<div class="content">
    <h2>📊 Dashboard GM</h2>
    <p>Ringkasan status pengesahan dokumen ISO</p>

    <!-- KPI -->
    <div class="grid">
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
    <div class="chart-grid">
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
        labels: <?= json_encode($statusLabel ?? ['Menunggu','Disahkan','Ditolak']) ?>,
        datasets: [{
            data: <?= json_encode($statusData ?? [0,0,0]) ?>,
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
        labels: <?= json_encode($monthLabel ?? []) ?>,
        datasets: [{
            label: 'Dokumen Disahkan',
            data: <?= json_encode($monthData ?? []) ?>,
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
