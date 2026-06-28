<?php
// Enhanced Dashboard with Charts
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laporan - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .chart-wrapper {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-mini {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .stat-mini-value {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        .stat-mini-label {
            font-size: 13px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="layout">
        <?php include BASE_PATH . '/views/layout/sidebar.php'; ?>
        <div class="main-content">
            <?php include BASE_PATH . '/views/layout/header.php'; ?>
            <div class="content">
                <h2>Dashboard Laporan</h2>

                <!-- Statistics -->
                <div class="stats-row">
                    <div class="stat-mini">
                        <i class="fas fa-graduation-cap" style="font-size: 32px; color: #3498db;"></i>
                        <div class="stat-mini-value"><?php echo $stats['total_students']; ?></div>
                        <div class="stat-mini-label">Total Siswa</div>
                    </div>
                    <div class="stat-mini">
                        <i class="fas fa-chalkboard-user" style="font-size: 32px; color: #2ecc71;"></i>
                        <div class="stat-mini-value"><?php echo $stats['total_teachers']; ?></div>
                        <div class="stat-mini-label">Total Guru</div>
                    </div>
                    <div class="stat-mini">
                        <i class="fas fa-cube" style="font-size: 32px; color: #e74c3c;"></i>
                        <div class="stat-mini-value"><?php echo $stats['total_assets']; ?></div>
                        <div class="stat-mini-label">Total Aset</div>
                    </div>
                    <div class="stat-mini">
                        <i class="fas fa-users" style="font-size: 32px; color: #f39c12;"></i>
                        <div class="stat-mini-value"><?php echo $stats['total_visitors']; ?></div>
                        <div class="stat-mini-label">Pengunjung Bulan Ini</div>
                    </div>
                </div>

                <!-- Financial Chart -->
                <div class="chart-container">
                    <h3><i class="fas fa-money-bill"></i> Grafik Keuangan (12 Bulan Terakhir)</h3>
                    <div class="chart-wrapper">
                        <canvas id="financialChart"></canvas>
                    </div>
                    <a href="/laporan/keuangan" class="btn btn-primary btn-small" style="margin-top: 10px;">
                        <i class="fas fa-arrow-right"></i> Lihat Laporan Lengkap
                    </a>
                </div>

                <!-- Asset Chart -->
                <div class="chart-container">
                    <h3><i class="fas fa-chart-pie"></i> Distribusi Aset Berdasarkan Kategori</h3>
                    <div class="chart-wrapper" style="height: 300px;">
                        <canvas id="assetChart"></canvas>
                    </div>
                    <a href="/laporan/aset" class="btn btn-primary btn-small" style="margin-top: 10px;">
                        <i class="fas fa-arrow-right"></i> Lihat Laporan Aset
                    </a>
                </div>

                <!-- Visitor Chart -->
                <div class="chart-container">
                    <h3><i class="fas fa-chart-bar"></i> Grafik Pengunjung (30 Hari Terakhir)</h3>
                    <div class="chart-wrapper">
                        <canvas id="visitorChart"></canvas>
                    </div>
                    <a href="/buku-tamu" class="btn btn-primary btn-small" style="margin-top: 10px;">
                        <i class="fas fa-arrow-right"></i> Lihat Buku Tamu
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Financial Chart
        const financialCtx = document.getElementById('financialChart')?.getContext('2d');
        if (financialCtx) {
            new Chart(financialCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($financialChart['labels'] ?? []); ?>,
                    datasets: [{
                        label: 'Saldo Akhir (Rp)',
                        data: <?php echo json_encode($financialChart['data'] ?? []); ?>,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Asset Chart
        const assetCtx = document.getElementById('assetChart')?.getContext('2d');
        if (assetCtx) {
            const assetData = <?php echo json_encode($assetChart ?? []); ?>;
            new Chart(assetCtx, {
                type: 'doughnut',
                data: {
                    labels: assetData.map(a => a.category),
                    datasets: [{
                        data: assetData.map(a => a.count),
                        backgroundColor: [
                            '#667eea',
                            '#2ecc71',
                            '#e74c3c',
                            '#f39c12',
                            '#9b59b6'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }

        // Visitor Chart
        const visitorCtx = document.getElementById('visitorChart')?.getContext('2d');
        if (visitorCtx) {
            new Chart(visitorCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($visitorChart['labels'] ?? []); ?>,
                    datasets: [{
                        label: 'Jumlah Pengunjung',
                        data: <?php echo json_encode($visitorChart['data'] ?? []); ?>,
                        backgroundColor: '#667eea'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
    <script src="/public/js/main.js"></script>
</body>
</html>
