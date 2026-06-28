<?php
// Financial Reports View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .report-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        .report-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        .report-info h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }
        .report-info p {
            color: #999;
            font-size: 13px;
        }
        .report-amount {
            font-size: 24px;
            font-weight: bold;
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="layout">
        <?php include BASE_PATH . '/views/layout/sidebar.php'; ?>
        <div class="main-content">
            <?php include BASE_PATH . '/views/layout/header.php'; ?>
            <div class="content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>Laporan Keuangan</h2>
                    <a href="/keuangan/buat" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Laporan
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>

                <div>
                    <?php if (!empty($reports)): ?>
                        <?php foreach ($reports as $report): ?>
                            <div class="report-card">
                                <div class="report-info">
                                    <h3>Laporan Bulan <?php echo date('F Y', mktime(0, 0, 0, $report['month'], 1, $report['year'])); ?></h3>
                                    <p>Status: <span style="color: #667eea; font-weight: 600;"><?php echo ucfirst($report['status']); ?></span></p>
                                </div>
                                <div>
                                    <div class="report-amount"><?php echo 'Rp ' . number_format($report['closing_balance'], 0, ',', '.'); ?></div>
                                    <a href="/keuangan/<?php echo $report['id']; ?>" style="color: #667eea; text-decoration: none; font-size: 12px;">
                                        <i class="fas fa-arrow-right"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="background: white; border-radius: 12px; padding: 40px; text-align: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);">
                            <i class="fas fa-file-invoice" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                            <p style="color: #999;">Belum ada laporan keuangan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>
