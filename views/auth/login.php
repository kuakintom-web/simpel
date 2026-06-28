<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPEL-Alkhairaat</title>
    <link rel="stylesheet" href="/public/css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <i class="fas fa-building"></i>
                <h1>SIMPEL-Alkhairaat</h1>
                <p>Sistem Informasi Manajemen Pendidikan Lengkap</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    Username atau password salah!
                </div>
            <?php endif; ?>

            <form method="POST" action="/login" class="login-form">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input type="text" id="username" name="username" required placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan password">
                </div>

                <div class="form-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="remember-label">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="login-footer">
                <p>© 2024 Alkhairaat. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>
</body>
</html>
