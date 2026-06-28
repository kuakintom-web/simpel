<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-building"></i>
                <span>SIMPEL</span>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item active">
                        <a href="/dashboard" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/sekolah" class="nav-link">
                            <i class="fas fa-school"></i>
                            <span>Data Sekolah</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/keuangan" class="nav-link">
                            <i class="fas fa-money-bill"></i>
                            <span>Laporan Keuangan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/aset" class="nav-link">
                            <i class="fas fa-cube"></i>
                            <span>Laporan Aset</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/buku-tamu" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>Buku Tamu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/surat" class="nav-link">
                            <i class="fas fa-envelope"></i>
                            <span>Surat Keluar/Masuk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/pengguna" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <a href="/logout" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <h2>Dashboard</h2>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span><?php echo htmlspecialchars($userName); ?></span>
                        <small><?php echo htmlspecialchars($userRole); ?></small>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h1>Selamat Datang, <?php echo htmlspecialchars($userName); ?>!</h1>
                    <p>Sistem Informasi Manajemen Pendidikan Lengkap - Alkhairaat</p>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: #3498db;">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Data Sekolah</h3>
                            <p class="stat-number">12</p>
                            <a href="/sekolah" class="stat-link">Lihat Detail →</a>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: #2ecc71;">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Laporan Keuangan</h3>
                            <p class="stat-number">Rp 2.5B</p>
                            <a href="/keuangan" class="stat-link">Lihat Detail →</a>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: #e74c3c;">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Total Aset</h3>
                            <p class="stat-number">856</p>
                            <a href="/aset" class="stat-link">Lihat Detail →</a>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: #f39c12;">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Pengunjung Bulan Ini</h3>
                            <p class="stat-number">142</p>
                            <a href="/buku-tamu" class="stat-link">Lihat Detail →</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="recent-section">
                    <h2>Aktivitas Terbaru</h2>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon" style="color: #3498db;">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="activity-content">
                                <p>Tambah Laporan Keuangan Baru</p>
                                <small>2 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="color: #2ecc71;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="activity-content">
                                <p>Persetujuan Data Sekolah</p>
                                <small>5 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="color: #e74c3c;">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="activity-content">
                                <p>Update Inventaris Aset</p>
                                <small>1 hari yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/main.js"></script>
</body>
</html>
