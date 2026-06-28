<?php
// Asset List View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aset - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .asset-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .asset-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-top: 4px solid #667eea;
        }
        .asset-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .asset-code {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .asset-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .asset-category {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            color: #666;
            margin-bottom: 12px;
        }
        .asset-info {
            font-size: 13px;
            margin-bottom: 8px;
            color: #666;
        }
        .asset-info i {
            width: 20px;
            color: #667eea;
            margin-right: 5px;
        }
        .asset-condition {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .condition-baik {
            background-color: #d4edda;
            color: #155724;
        }
        .condition-rusak-ringan {
            background-color: #fff3cd;
            color: #856404;
        }
        .condition-rusak-berat {
            background-color: #f8d7da;
            color: #721c24;
        }
        .asset-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }
        .btn-small {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-view {
            background-color: #3498db;
            color: white;
        }
        .btn-view:hover {
            background-color: #2980b9;
        }
        .btn-edit {
            background-color: #2ecc71;
            color: white;
        }
        .btn-edit:hover {
            background-color: #27ae60;
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
                    <h2>Laporan Aset</h2>
                    <a href="/aset/buat" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Aset
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($assets)): ?>
                    <div class="asset-grid">
                        <?php foreach ($assets as $asset): ?>
                            <div class="asset-card">
                                <div class="asset-code"><?php echo htmlspecialchars($asset['asset_code']); ?></div>
                                <div class="asset-name"><?php echo htmlspecialchars($asset['name']); ?></div>
                                <div class="asset-category"><?php echo htmlspecialchars($asset['category']); ?></div>
                                
                                <div class="asset-info">
                                    <i class="fas fa-cube"></i>
                                    Jumlah: <?php echo $asset['quantity'] . ' ' . htmlspecialchars($asset['unit']); ?>
                                </div>
                                <div class="asset-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo htmlspecialchars($asset['location']); ?>
                                </div>
                                <div class="asset-info">
                                    <i class="fas fa-calendar"></i>
                                    <?php echo date('d M Y', strtotime($asset['purchase_date'])); ?>
                                </div>
                                
                                <div class="asset-condition condition-<?php echo str_replace(' ', '-', $asset['current_condition']); ?>">
                                    <?php echo ucfirst($asset['current_condition']); ?>
                                </div>
                                
                                <div class="asset-actions">
                                    <a href="/aset/<?php echo $asset['id']; ?>" class="btn-small btn-view">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="/aset/edit/<?php echo $asset['id']; ?>" class="btn-small btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="background: white; border-radius: 12px; padding: 40px; text-align: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);">
                        <i class="fas fa-cube" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                        <p style="color: #999;">Belum ada data aset</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>
