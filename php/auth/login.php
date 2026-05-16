<?php
session_start();

if (!empty($_SESSION['user_id'])) {
    header(
        'Location: ' . (
            $_SESSION['role'] === 'admin'
                ? '../../page/admin-dashboard.php'
                : '../../index.php'
        )
    );
    exit;
}

require '../config/config.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            if ($row['role'] == 'admin') {
                $_SESSION['login']   = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nama']    = $row['nama'];
                $_SESSION['email']   = $row['email'];
                $_SESSION['role']    = $row['role'];

                header("Location: ../../page/admin-dashboard.php");
            } else {
                $_SESSION['login']   = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nama']    = $row['nama'];
                $_SESSION['email']   = $row['email'];
                $_SESSION['role']    = $row['role'];

                header("Location: ../../index.php");
            }
            exit;
        } else {
            echo "<script>alert('Password salah'); document.location.href='login.php'</script>";
        }
    } else {
        echo "<script>alert('Akun tidak tersedia'); document.location.href='login.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sahabatku</title>

    <link rel="stylesheet" href="../../css/sahabatku.css">
    <link rel="stylesheet" href="../../css/sahabatku-auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../../assets/logo 1.png" type="image/x-icon">
</head>

<body>
<div class="auth-card" style="max-width:420px">

    <div class="auth-logo">
        <a href="../../index.php">Sahabatku</a>
        <p>Penyedia Layanan Internet Terpercaya</p>
    </div>

    <h1 class="auth-title">Masuk</h1>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                    <i class="bi bi-eye" id="eye-password"></i>
                </button>
            </div>
        </div>

        <button type="submit" name="login" class="btn-auth">
            Masuk
        </button>

        <div class="auth-footer">
            Belum punya akun?
            <a href="register.php">Daftar sekarang</a>
        </div>
    </form>

    <a href="../../index.php" class="back-home">
        ← Kembali ke Beranda
    </a>
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