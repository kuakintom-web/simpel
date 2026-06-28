<?php
// Sidebar Component
?>
<div class="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-building"></i>
        <span>SIMPEL</span>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
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
            <?php if ($_SESSION['user_role'] !== 'admin_sekolah'): ?>
                <li class="nav-item">
                    <a href="/pengguna" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="/logout" class="btn btn-logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>
</div>
