<?php
// Backup Management View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Backup - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .backup-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .backup-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .backup-list {
            margin-top: 20px;
        }
        .backup-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #667eea;
        }
        .backup-info h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
        }
        .backup-info p {
            margin: 0;
            font-size: 12px;
            color: #999;
        }
        .backup-actions-btns {
            display: flex;
            gap: 8px;
        }
        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-download {
            background-color: #3498db;
            color: white;
        }
        .btn-download:hover {
            background-color: #2980b9;
        }
        .btn-restore {
            background-color: #2ecc71;
            color: white;
        }
        .btn-restore:hover {
            background-color: #27ae60;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #155724;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #0c5460;
        }
    </style>
</head>
<body>
    <div class="layout">
        <?php include BASE_PATH . '/views/layout/sidebar.php'; ?>
        <div class="main-content">
            <?php include BASE_PATH . '/views/layout/header.php'; ?>
            <div class="content">
                <h2><i class="fas fa-database"></i> Manajemen Backup</h2>

                <div class="backup-section">
                    <h3>Buat Backup Baru</h3>
                    <p>Buat backup database untuk mencegah kehilangan data</p>
                    <div class="backup-actions">
                        <form method="POST" action="/backup/create" style="display: inline;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Backup Sekarang
                            </button>
                        </form>
                    </div>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['info'])): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <?php echo htmlspecialchars($_GET['info']); ?>
                    </div>
                <?php endif; ?>

                <div class="backup-section">
                    <h3>Daftar Backup</h3>
                    
                    <?php if (!empty($backups)): ?>
                        <div class="backup-list">
                            <?php foreach ($backups as $backup): ?>
                                <div class="backup-item">
                                    <div class="backup-info">
                                        <h3><i class="fas fa-file"></i> <?php echo htmlspecialchars($backup['filename']); ?></h3>
                                        <p>
                                            Dibuat: <?php echo $backup['created']; ?> | 
                                            Ukuran: <?php echo number_format($backup['size'] / 1024, 2); ?> KB
                                        </p>
                                    </div>
                                    <div class="backup-actions-btns">
                                        <a href="/backup/download/<?php echo urlencode($backup['filename']); ?>" class="btn-action btn-download">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <form method="POST" action="/backup/restore" style="display: inline;">
                                            <input type="hidden" name="filename" value="<?php echo htmlspecialchars($backup['filename']); ?>">
                                            <button type="submit" class="btn-action btn-restore" onclick="return confirm('Apakah Anda yakin ingin restore backup ini?');">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                        </form>
                                        <form method="POST" action="/backup/delete" style="display: inline;">
                                            <input type="hidden" name="filename" value="<?php echo htmlspecialchars($backup['filename']); ?>">
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus backup ini?');">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px; color: #999;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                            <p>Belum ada backup yang tersimpan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>
