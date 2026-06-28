# SIMPEL-Alkhairaat

Sistem Informasi Manajemen Pendidikan Lengkap - Alkhairaat adalah aplikasi web berbasis PHP murni untuk mengelola data Madrasah/Sekolah Alkhairaat secara terintegrasi.

## Fitur Utama

- 📊 **Laporan Data Madrasah** - Manajemen data sekolah dan siswa
- 💰 **Laporan Keuangan** - Pencatatan pemasukan dan pengeluaran
- 🏢 **Laporan Aset** - Inventori aset sekolah
- 📖 **Buku Tamu** - Pencatatan pengunjung
- 📮 **Surat Keluar/Masuk** - Manajemen surat dan dokumen

## Level Pengelola

1. **Administrator Pusat** - Mengelola semua cabang di seluruh Indonesia
2. **Admin Kabupaten** - Mengelola sekolah dalam kabupaten
3. **Admin Kecamatan** - Mengelola cabang Alkhairaat di kecamatan
4. **Admin Sekolah** - Mengelola data sekolah masing-masing

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Server Apache dengan mod_rewrite
- Web Browser modern (Chrome, Firefox, Safari, Edge)

## Instalasi

1. Upload semua file ke folder public_html di hosting
2. Import database: `database/simpel_alkhairaat.sql`
3. Konfigurasi file `.env` sesuai server Anda
4. Akses aplikasi melalui browser

## Struktur Folder

```
simpel-alkhairaat/
├── config/              # Konfigurasi aplikasi
├── app/
│   ├── controllers/     # Controller aplikasi
│   ├── models/          # Model data
│   ├── middleware/      # Middleware
│   └── helpers/         # Helper functions
├── public/
│   ├── css/             # Stylesheet
│   ├── js/              # JavaScript
│   ├── img/             # Gambar
│   └── index.php        # Entry point
├── views/               # Template view
├── database/            # SQL migration
└── storage/             # Temporary files
```

## User Standar

- **Admin Pusat**: admin_pusat / pusat123
- **Admin Kabupaten**: admin_kab / kab123
- **Admin Kecamatan**: admin_kec / kec123
- **Admin Sekolah**: admin_sekolah / sekolah123

## Support

Untuk bantuan, hubungi tim development atau buka issue di repository.
