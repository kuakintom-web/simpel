<?php
// Asset Create Form
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aset - SIMPEL-Alkhairaat</title>
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
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
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
                    <h2><i class="fas fa-plus-circle"></i> Tambah Aset Baru</h2>
                    
                    <form method="POST" action="/aset/simpan">
                        <div class="form-group">
                            <label for="asset_code">Kode Aset *</label>
                            <input type="text" id="asset_code" name="asset_code" required placeholder="Contoh: AST-001">
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Aset *</label>
                            <input type="text" id="name" name="name" required placeholder="Contoh: Laptop Dell">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="category">Kategori *</label>
                                <select id="category" name="category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                    <option value="Peralatan">Peralatan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Jumlah *</label>
                                <input type="number" id="quantity" name="quantity" required value="1" min="1">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="unit">Unit *</label>
                                <select id="unit" name="unit" required>
                                    <option value="Buah">Buah</option>
                                    <option value="Set">Set</option>
                                    <option value="Unit">Unit</option>
                                    <option value="Pasang">Pasang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="purchase_price">Harga Pembelian (Rp)</label>
                                <input type="number" id="purchase_price" name="purchase_price" value="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="purchase_date">Tanggal Pembelian</label>
                                <input type="date" id="purchase_date" name="purchase_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="location">Lokasi *</label>
                                <input type="text" id="location" name="location" required placeholder="Contoh: Ruang Lab Komputer">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" placeholder="Deskripsi detail aset..."></textarea>
                        </div>

                        <div class="btn-group">
                            <a href="/aset" class="btn-cancel">Batal</a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Simpan Aset
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
