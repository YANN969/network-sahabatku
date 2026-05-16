<?php
require '../config/config.php';
require '../function/function.php';

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
                alert('Registrasi Berhasil');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>alert('Registrasi Gagal');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Sahabatku</title>
    <link rel="stylesheet" href="../../css/sahabatku.css">
    <link rel="stylesheet" href="../../css/sahabatku-auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../../assets/logo 1.png" type="image/x-icon">
</head>

<body>
<div class="auth-card" style="max-width:760px">

    <div class="auth-logo">
        <a href="../index.php">Sahabatku</a>
        <p>Penyedia Layanan Internet Terpercaya</p>
    </div>

    <h1 class="auth-title">Buat Akun Baru</h1>

    <form method="POST">
        <div class="reg-grid">

            <!-- KIRI -->
            <div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama"
                        placeholder="Masukkan nama lengkap"
                        value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        placeholder="Masukkan email Anda"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="telepon">Nomor Telepon</label>
                    <input type="number" id="telepon" name="telepon"
                        placeholder="Contoh: 08123456789"
                        value="<?= htmlspecialchars($_POST['telepon'] ?? '') ?>" required>
                </div>
            </div>

            <!-- KANAN -->
            <div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat"
                        placeholder="Masukkan alamat lengkap"
                        value="<?= htmlspecialchars($_POST['alamat'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                            <i class="bi bi-eye" id="eye-password"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                            <i class="bi bi-eye" id="eye-password"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <hr class="divider">

        <button type="submit" name="register" class="btn-auth">
            Daftar Sekarang
        </button>

        <div class="auth-footer">
            Sudah punya akun? <a href="login.php">Masuk di sini</a>
        </div>
    </form>

    <a href="../../index.php" class="back-home">← Kembali ke Beranda</a>

</div>
<script>
function togglePassword(id, btn) {
    var el = document.getElementById(id);
    var icon = btn.querySelector('i');

    el.type = el.type === 'password' ? 'text' : 'password';
    icon.className = el.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>

</body>
</html>