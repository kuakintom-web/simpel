<?php
// Letter List View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keluar/Masuk - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }
        .tab {
            padding: 12px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #999;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .tab.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }
        .letter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }
        .letter-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }
        .letter-card.keluar {
            border-left-color: #e74c3c;
        }
        .letter-card.masuk {
            border-left-color: #2ecc71;
        }
        .letter-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }
        .letter-number {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .letter-type {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .type-keluar {
            background-color: #fdeaea;
            color: #c33;
        }
        .type-masuk {
            background-color: #eafdf0;
            color: #060;
        }
        .letter-subject {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .letter-info {
            display: flex;
            gap: 20px;
            font-size: 12px;
            color: #666;
            margin-bottom: 12px;
        }
        .letter-info i {
            width: 16px;
            color: #667eea;
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
                    <h2>Surat Keluar/Masuk</h2>
                    <div style="display: flex; gap: 10px;">
                        <a href="/surat/buat?type=keluar" class="btn btn-primary">
                            <i class="fas fa-arrow-up"></i> Surat Keluar
                        </a>
                        <a href="/surat/buat?type=masuk" class="btn btn-primary">
                            <i class="fas fa-arrow-down"></i> Surat Masuk
                        </a>
                    </div>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>

                <div>
                    <?php if (!empty($letters)): ?>
                        <?php foreach ($letters as $letter): ?>
                            <div class="letter-card <?php echo $letter['letter_type']; ?>">
                                <div class="letter-header">
                                    <div>
                                        <div class="letter-number"><?php echo htmlspecialchars($letter['letter_number']); ?></div>
                                        <div class="letter-subject"><?php echo htmlspecialchars($letter['subject']); ?></div>
                                    </div>
                                    <div class="letter-type type-<?php echo $letter['letter_type']; ?>">
                                        <?php echo $letter['letter_type'] === 'keluar' ? 'KELUAR' : 'MASUK'; ?>
                                    </div>
                                </div>
                                <div class="letter-info">
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('d M Y', strtotime($letter['letter_date'])); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-user"></i>
                                        <?php echo htmlspecialchars($letter['sender_recipient']); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-check"></i>
                                        <?php echo ucfirst($letter['status']); ?>
                                    </span>
                                </div>
                                <a href="/surat/<?php echo $letter['id']; ?>" style="color: #667eea; text-decoration: none; font-size: 12px;">
                                    <i class="fas fa-arrow-right"></i> Lihat Detail
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="background: white; border-radius: 12px; padding: 40px; text-align: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);">
                            <i class="fas fa-envelope" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                            <p style="color: #999;">Belum ada surat</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>
