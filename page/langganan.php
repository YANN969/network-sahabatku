<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../php/auth/login.php');
    exit;
}
require_once '../php/config/config.php';
require_once '../php/function/function.php';

$paket_id = (int) ($_GET['paket_id'] ?? $_POST['paket_id'] ?? 0);
$paket = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pakets WHERE id = $paket_id"));

$user_id = (int) $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama, telepon, alamat FROM users WHERE id = $user_id"));

if (isset($_POST['submit'])) {
    if (ajukanLangganan($conn, $user_id, $paket_id, $_POST) > 0) {
        echo "<script>alert('Pengajuan berhasil!'); window.location='../index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Langganan — Sahabatku</title>
    <link rel="stylesheet" href="../css/sahabatku.css">
    <link rel="stylesheet" href="../css/sahabatku-auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../assets/logo 1.png" type="image/x-icon">
</head>
<body>
    <div class="auth-card" style="max-width:520px">
        <div class="auth-logo">
            <a href="../index.php">Sahabatku</a>
        </div>
        <h1 class="auth-title">Pengajuan Langganan</h1>

        <!-- Isi Paket -->
        <div style="background:rgba(250,161,143,0.1);border:1px solid rgba(250,161,143,0.3);border-radius:10px;padding:16px;margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <span style="color:#ccc;font-size:14px;">Paket</span>
                <span style="color:#fff;font-weight:700;"><?= htmlspecialchars($paket['nama']) ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <span style="color:#ccc;font-size:14px;">Kecepatan</span>
                <span style="color:#fff;font-weight:600;"><?= htmlspecialchars($paket['speed']) ?></span>
            </div>
            <hr style="border-color:rgba(250,161,143,0.2);margin:10px 0;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="color:#FAA18F;font-weight:700;font-size:15px;">Total / Bulan</span>
                <span style="color:#FAA18F;font-weight:700;font-size:20px;">Rp <?= number_format($paket['harga'], 0, ',', '.') ?></span>
            </div>
        </div>

        <form method="POST">
            <input type="hidden" name="paket_id" value="<?= $paket_id ?>">

            <!-- Metode Pembayaran -->
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#ccc;margin-bottom:10px;">Metode Pembayaran</label>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <label style="flex:1;min-width:120px;cursor:pointer;">
                        <input type="radio" name="metode_bayar" value="transfer" checked class="payment-radio" style="display:none;">
                        <div class="payment-option" style="border:2px solid #FAA18F;border-radius:8px;padding:10px 14px;text-align:center;background:rgba(250,161,143,0.1);">
                            <i class="bi bi-bank" style="font-size:20px;color:#FAA18F;display:block;margin-bottom:4px;"></i>
                            <span style="font-size:13px;color:#fff;">Transfer Bank</span>
                        </div>
                    </label>
                    <label style="flex:1;min-width:120px;cursor:pointer;">
                        <input type="radio" name="metode_bayar" value="kartu_kredit" class="payment-radio" style="display:none;">
                        <div class="payment-option" style="border:2px solid rgba(255,255,255,0.15);border-radius:8px;padding:10px 14px;text-align:center;">
                            <i class="bi bi-cash-coin" style="font-size:20px;color:#ccc;display:block;margin-bottom:4px;"></i>
                            <span style="font-size:13px;color:#ccc;">KartuKredit</span>
                        </div>
                    </label>
                    <label style="flex:1;min-width:120px;cursor:pointer;">
                        <input type="radio" name="metode_bayar" value="ewallet" class="payment-radio" style="display:none;">
                        <div class="payment-option" style="border:2px solid rgba(255,255,255,0.15);border-radius:8px;padding:10px 14px;text-align:center;">
                            <i class="bi bi-wallet2" style="font-size:20px;color:#ccc;display:block;margin-bottom:4px;"></i>
                            <span style="font-size:13px;color:#ccc;">E-Wallet</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="tel" name="telepon" placeholder="08123456789"
                    value="<?= htmlspecialchars($user['telepon'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Alamat Instalasi</label>
                <input type="text" name="alamat" placeholder="Alamat lengkap"
                    value="<?= htmlspecialchars($user['alamat'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="catatan" rows="3"></textarea>
            </div>
            <button type="submit" name="submit" class="btn-auth">Kirim Pengajuan</button>
        </form>

        <a href="../index.php" class="back-home">← Kembali ke Beranda</a>
    </div>

<script>
document.querySelectorAll('.payment-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.payment-option').forEach(function(opt) {
            opt.style.borderColor = 'rgba(255,255,255,0.15)';
            opt.style.background = 'transparent';
            opt.querySelector('i').style.color = '#ccc';
            opt.querySelector('span').style.color = '#ccc';
        });
        var selected = this.nextElementSibling;
        selected.style.borderColor = '#FAA18F';
        selected.style.background = 'rgba(250,161,143,0.1)';
        selected.querySelector('i').style.color = '#FAA18F';
        selected.querySelector('span').style.color = '#fff';
    });
});
</script>
</body>
</html>
