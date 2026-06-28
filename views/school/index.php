<?php
// School List View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sekolah - SIMPEL-Alkhairaat</title>
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
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
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
                    <h2>Data Sekolah</h2>
                    <a href="/sekolah/buat" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Sekolah
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
                                <th>Nama Sekolah</th>
                                <th>NPSN</th>
                                <th>Kepala Sekolah</th>
                                <th>Siswa</th>
                                <th>Guru</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($schools)): ?>
                                <?php foreach ($schools as $key => $school): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo htmlspecialchars($school['name']); ?></td>
                                        <td><?php echo htmlspecialchars($school['npsn']); ?></td>
                                        <td><?php echo htmlspecialchars($school['principal_name']); ?></td>
                                        <td><?php echo $school['total_students']; ?></td>
                                        <td><?php echo $school['total_teachers']; ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="/sekolah/<?php echo $school['id']; ?>" class="btn-small btn-view">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                                <a href="/sekolah/edit/<?php echo $school['id']; ?>" class="btn-small btn-edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #999; padding: 40px;">
                                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
                                        <p>Belum ada data sekolah</p>
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
