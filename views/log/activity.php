<?php
// Activity Log View
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .log-filters {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .log-filters input,
        .log-filters select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 12px;
        }
        .log-table {
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
        .action-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .action-create {
            background-color: #d4edda;
            color: #155724;
        }
        .action-update {
            background-color: #fff3cd;
            color: #856404;
        }
        .action-delete {
            background-color: #f8d7da;
            color: #721c24;
        }
        .action-login {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .action-export {
            background-color: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>
<body>
    <div class="layout">
        <?php include BASE_PATH . '/views/layout/sidebar.php'; ?>
        <div class="main-content">
            <?php include BASE_PATH . '/views/layout/header.php'; ?>
            <div class="content">
                <h2><i class="fas fa-history"></i> Log Aktivitas Pengguna</h2>

                <div class="log-filters">
                    <form method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; flex: 1;">
                        <input type="text" name="search" placeholder="Cari aktivitas..." value="<?php echo $_GET['search'] ?? ''; ?>">
                        <select name="module">
                            <option value="">Semua Modul</option>
                            <option value="auth" <?php echo ($_GET['module'] ?? '') === 'auth' ? 'selected' : ''; ?>>Authentication</option>
                            <option value="schools" <?php echo ($_GET['module'] ?? '') === 'schools' ? 'selected' : ''; ?>>Sekolah</option>
                            <option value="financial" <?php echo ($_GET['module'] ?? '') === 'financial' ? 'selected' : ''; ?>>Keuangan</option>
                            <option value="assets" <?php echo ($_GET['module'] ?? '') === 'assets' ? 'selected' : ''; ?>>Aset</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="padding: 8px 15px;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </form>
                </div>

                <div class="log-table">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                                <th>Modul</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $key => $log): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo htmlspecialchars($log['user_name'] ?? 'System'); ?></td>
                                        <td>
                                            <?php 
                                                $actionClass = 'action-' . strtolower(str_replace('_', '-', $log['action']));
                                                if (!preg_match('/^action-/', $actionClass)) {
                                                    $actionClass = 'action-export';
                                                }
                                            ?>
                                            <span class="action-badge <?php echo $actionClass; ?>">
                                                <?php echo htmlspecialchars($log['action']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($log['module']); ?></td>
                                        <td><?php echo htmlspecialchars($log['description']); ?></td>
                                        <td><code><?php echo htmlspecialchars($log['ip_address']); ?></code></td>
                                        <td><?php echo date('d M Y H:i:s', strtotime($log['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #999; padding: 40px;">
                                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                        Belum ada log aktivitas
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
