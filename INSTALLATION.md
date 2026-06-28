# Panduan Instalasi SIMPEL-Alkhairaat

## Persyaratan Sistem

- **PHP**: 7.4 atau lebih tinggi
- **MySQL**: 5.7 atau lebih tinggi
- **Apache**: Dengan mod_rewrite enabled
- **Browser**: Chrome, Firefox, Safari, atau Edge versi terbaru

## Langkah Instalasi

### 1. Upload File ke Hosting

```bash
git clone https://github.com/kuakintom-web/simpel.git
cd simpel
```

Atau upload semua file ke folder `public_html` di hosting Anda.

### 2. Buat Database

1. Buka phpMyAdmin
2. Buat database baru dengan nama `simpel_alkhairaat`
3. Import file `database/simpel_alkhairaat.sql`

```bash
mysql -u root -p simpel_alkhairaat < database/simpel_alkhairaat.sql
```

### 3. Konfigurasi File .env

1. Copy `.env.example` menjadi `.env`
2. Edit file `.env` dan sesuaikan dengan konfigurasi server Anda:

```env
DB_HOST=localhost
DB_USER=root
DB_PASS=password_anda
DB_NAME=simpel_alkhairaat
DB_PORT=3306

APP_URL=http://yoursite.com
APP_ENV=production
```

### 4. Verifikasi Folder Permissions

Pastikan folder berikut memiliki permission yang tepat:

```bash
chmod -R 755 storage/
chmod -R 755 public/uploads/
```

### 5. Akses Aplikasi

Buka browser dan akses:
```
http://yoursite.com
```

Atau jika di localhost:
```
http://localhost/simpel
```

## Login Default

| Role | Username | Password |
|------|----------|----------|
| Admin Pusat | admin_pusat | pusat123 |
| Admin Kabupaten | admin_kab | kab123 |
| Admin Kecamatan | admin_kec | kec123 |
| Admin Sekolah | admin_sekolah | sekolah123 |

**⚠️ Pastikan mengubah password ini setelah login pertama kali!**

## Struktur Database

### Tabel Utama:

- **users** - Data pengguna dan admin
- **provinces** - Data provinsi
- **regencies** - Data kabupaten
- **districts** - Data kecamatan
- **schools** - Data sekolah/madrasah
- **financial_reports** - Laporan keuangan
- **financial_transactions** - Transaksi keuangan
- **assets** - Data aset sekolah
- **visitor_books** - Buku tamu
- **letters** - Surat masuk/keluar
- **activity_logs** - Log aktivitas pengguna

## Fitur Utama

### 1. Dashboard
- Menampilkan statistik umum
- Aktivitas terbaru
- Quick access ke semua modul

### 2. Data Sekolah
- Input data madrasah/sekolah
- Kelola informasi sekolah
- Data kepala sekolah, siswa, guru

### 3. Laporan Keuangan
- Buat laporan bulanan
- Input pemasukan dan pengeluaran
- Laporan per kategori
- Export laporan

### 4. Laporan Aset
- Inventori aset sekolah
- Tracking kondisi barang
- Laporan aset per kategori
- Riwayat pemeliharaan

### 5. Buku Tamu
- Pencatatan pengunjung
- Data pengunjung
- Filter berdasarkan tanggal
- Laporan pengunjung

### 6. Surat Keluar/Masuk
- Input surat masuk
- Input surat keluar
- Nomor surat otomatis
- Upload dokumen
- Tracking status surat

### 7. Manajemen Pengguna
- Kelola admin pusat
- Kelola admin kabupaten
- Kelola admin kecamatan
- Kelola admin sekolah
- Kontrol akses berdasarkan role

## Role dan Permissions

### Admin Pusat
- Akses ke semua data
- Kelola semua cabang
- Kelola admin kabupaten
- Laporan pusat

### Admin Kabupaten
- Kelola sekolah dalam kabupaten
- Kelola admin kecamatan
- Laporan kabupaten

### Admin Kecamatan
- Kelola cabang kecamatan
- Kelola admin sekolah
- Laporan kecamatan

### Admin Sekolah
- Kelola data sekolah
- Input laporan keuangan
- Kelola aset
- Input buku tamu
- Input surat

## Troubleshooting

### 1. Error "Database connection failed"

**Solusi:**
- Pastikan MySQL running
- Cek konfigurasi di file `.env`
- Cek username dan password database

### 2. Error "404 Not Found"

**Solusi:**
- Pastikan mod_rewrite enabled di Apache
- Edit .htaccess jika ada
- Cek path folder aplikasi

### 3. Error "Permission Denied"

**Solusi:**
- Set permission folder ke 755
- Set permission file ke 644

### 4. Login gagal

**Solusi:**
- Clear browser cache
- Cek session directory readable/writable
- Pastikan cookies enabled

## Update Password

Untuk update password user:

1. Login dengan akun admin
2. Buka menu Manajemen Pengguna
3. Pilih user yang ingin diupdate
4. Klik Edit dan ubah password
5. Simpan perubahan

## Backup Database

Untuk backup database secara berkala:

```bash
mysqldump -u root -p simpel_alkhairaat > backup_simpel_$(date +%Y%m%d).sql
```

## Support & Help

Untuk bantuan teknis, silakan hubungi:
- Email: support@alkhairaat.sch.id
- Phone: +62-xxx-xxxx-xxxx

---

**Terima kasih telah menggunakan SIMPEL-Alkhairaat!**
