<?php
// Visitor Create Form
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengunjung - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            max-width: 600px;
            margin: 20px auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn-submit,
        .btn-cancel {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-submit {
            background-color: #667eea;
            color: white;
        }
        .btn-submit:hover {
            background-color: #764ba2;
        }
        .btn-cancel {
            background-color: #e0e0e0;
            color: #333;
            text-decoration: none;
            text-align: center;
        }
        .btn-cancel:hover {
            background-color: #d0d0d0;
        }
    </style>
</head>
<body>
    <div class="layout">
        <?php include BASE_PATH . '/views/layout/sidebar.php'; ?>
        <div class="main-content">
            <?php include BASE_PATH . '/views/layout/header.php'; ?>
            <div class="content">
                <div class="form-container">
                    <h2><i class="fas fa-user-plus"></i> Tambah Pengunjung Baru</h2>
                    
                    <form method="POST" action="/buku-tamu/simpan">
                        <div class="form-group">
                            <label for="visitor_name">Nama Pengunjung *</label>
                            <input type="text" id="visitor_name" name="visitor_name" required placeholder="Nama lengkap pengunjung">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="visitor_phone">Nomor Telepon</label>
                                <input type="tel" id="visitor_phone" name="visitor_phone" placeholder="08xx-xxxx-xxxx">
                            </div>
                            <div class="form-group">
                                <label for="visitor_email">Email</label>
                                <input type="email" id="visitor_email" name="visitor_email" placeholder="email@example.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="visitor_organization">Organisasi/Instansi</label>
                            <input type="text" id="visitor_organization" name="visitor_organization" placeholder="Nama organisasi">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="visit_date">Tanggal Kunjungan *</label>
                                <input type="datetime-local" id="visit_date" name="visit_date" required value="<?php echo date('Y-m-d\TH:i'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="purpose">Tujuan Kunjungan *</label>
                            <textarea id="purpose" name="purpose" required placeholder="Jelaskan tujuan kunjungan..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="remarks">Catatan</label>
                            <textarea id="remarks" name="remarks" placeholder="Catatan tambahan..."></textarea>
                        </div>

                        <div class="btn-group">
                            <a href="/buku-tamu" class="btn-cancel">Batal</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>
