<?php
// Visitor Book List View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f9f9f9;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .visitor-name {
            font-weight: 600;
            color: #333;
        }
        .visitor-org {
            font-size: 12px;
            color: #999;
        }
        .visitor-date {
            font-size: 13px;
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
                    <h2>Buku Tamu</h2>
                    <a href="/buku-tamu/buat" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pengunjung
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengunjung</th>
                                <th>Organisasi</th>
                                <th>Tujuan</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Kontak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($visitors)): ?>
                                <?php foreach ($visitors as $key => $visitor): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><div class="visitor-name"><?php echo htmlspecialchars($visitor['visitor_name']); ?></div></td>
                                        <td><div class="visitor-org"><?php echo htmlspecialchars($visitor['visitor_organization']); ?></div></td>
                                        <td><?php echo htmlspecialchars(substr($visitor['purpose'], 0, 30)); ?>...</td>
                                        <td><div class="visitor-date"><?php echo date('d M Y H:i', strtotime($visitor['visit_date'])); ?></div></td>
                                        <td><?php echo htmlspecialchars($visitor['visitor_phone']); ?></td>
                                        <td>
                                            <a href="/buku-tamu/<?php echo $visitor['id']; ?>" style="color: #667eea; text-decoration: none;">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #999; padding: 40px;">
                                        <i class="fas fa-book" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                        Belum ada data pengunjung
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>
