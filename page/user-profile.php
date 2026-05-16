<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../php/auth/login.php');
    exit;
}
require_once '../php/config/config.php';

$user_id = (int) $_SESSION['user_id'];

// Ambil data user
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));

// Ambil langganan user
$res = mysqli_query($conn, "
    SELECT l.*, p.nama AS nama_paket, p.speed, p.harga
    FROM langganan l
    JOIN pakets p ON l.paket_id = p.id
    WHERE l.user_id = $user_id
    ORDER BY l.created_at DESC
");
$langganan = [];
while ($row = mysqli_fetch_assoc($res)) $langganan[] = $row;

$status_color = [
    'menunggu'   => '#856404',
    'diproses'   => '#0c5460',
    'aktif'      => '#155724',
    'ditolak'    => '#721c24',
    'dibatalkan' => '#721c24',
];
$status_bg = [
    'menunggu'   => '#fff3cd',
    'diproses'   => '#d1ecf1',
    'aktif'      => '#d4edda',
    'ditolak'    => '#f8d7da',
    'dibatalkan' => '#f8d7da',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil — Sahabatku</title>
    <link rel="stylesheet" href="../css/sahabatku.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../assets/logo 1.png" type="image/x-icon">
    <style>
        body { background: #180501; min-height: 100vh; padding: 40px 16px; }
        .profile-wrap { max-width: 520px; margin: 0 auto; }
        .profile-header {
            display: flex; align-items: center; gap: 20px;
            background: rgba(250,161,143,0.08);
            border: 1px solid rgba(250,161,143,0.2);
            border-radius: 14px; padding: 24px; margin-bottom: 20px;
        }
        .profile-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: #FAA18F; color: #180501;
            font-size: 28px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .profile-name { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .profile-email { font-size: 13px; color: #aaa; }
        .info-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px; padding: 20px; margin-bottom: 20px;
        }
        .info-card h3 {
            font-size: 13px; font-weight: 600; color: #FAA18F;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;
        }
        .info-row {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-row i { color: #FAA18F; font-size: 16px; margin-top: 2px; flex-shrink: 0; }
        .info-label { font-size: 12px; color: #888; margin-bottom: 2px; }
        .info-value { font-size: 14px; color: #fff; }
        .sub-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px; padding: 16px; margin-bottom: 12px;
        }
        .sub-card:last-child { margin-bottom: 0; }
        .sub-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .sub-name { font-size: 15px; font-weight: 700; color: #fff; }
        .sub-badge {
            font-size: 11px; font-weight: 600; padding: 3px 10px;
            border-radius: 20px;
        }
        .sub-detail { font-size: 13px; color: #aaa; }
        .sub-harga { font-size: 14px; font-weight: 700; color: #FAA18F; margin-top: 6px; }
        .empty-sub { text-align: center; color: #666; font-size: 14px; padding: 20px 0; }
        .back-link {
            display: flex; align-items: center; gap: 8px;
            color: #FAA18F; font-size: 14px; text-decoration: none;
            margin-bottom: 24px;
        }
        .back-link:hover { color: #fff; }
        .logout-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 12px; border-radius: 10px;
            background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.3);
            color: #ff6b6b; font-size: 14px; font-weight: 600;
            text-decoration: none; margin-top: 8px; transition: background 0.2s;
        }
        .logout-btn:hover { background: rgba(220,53,69,0.3); }
    </style>
</head>
<body>
    <div class="profile-wrap">

        <a href="../index.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>

        <!-- Header Profil -->
        <div class="profile-header">
            <div class="profile-avatar"><?= strtoupper(substr($user['nama'], 0, 1)) ?></div>
            <div>
                <div class="profile-name"><?= htmlspecialchars($user['nama']) ?></div>
                <div class="profile-email"><?= htmlspecialchars($user['email']) ?></div>
            </div>
        </div>

        <!-- Info Akun -->
        <div class="info-card">
            <h3>Informasi Akun</h3>
            <div class="info-row">
                <i class="bi bi-telephone-fill"></i>
                <div>
                    <div class="info-label">Nomor Telepon</div>
                    <div class="info-value"><?= htmlspecialchars($user['telepon'] ?? '—') ?></div>
                </div>
            </div>
            <div class="info-row">
                <i class="bi bi-geo-alt-fill"></i>
                <div>
                    <div class="info-label">Alamat</div>
                    <div class="info-value"><?= htmlspecialchars($user['alamat'] ?? '—') ?></div>
                </div>
            </div>
            <div class="info-row">
                <i class="bi bi-calendar3"></i>
                <div>
                    <div class="info-label">Bergabung Sejak</div>
                    <div class="info-value"><?= date('d M Y', strtotime($user['created_at'])) ?></div>
                </div>
            </div>
        </div>

        <!-- Langganan -->
        <div class="info-card">
            <h3>Langganan Saya</h3>
            <?php if (empty($langganan)): ?>
                <div class="empty-sub">
                    <i class="bi bi-wifi-off" style="font-size:32px;display:block;margin-bottom:8px;color:#444;"></i>
                    Belum ada langganan aktif
                </div>
            <?php else: ?>
                <?php foreach ($langganan as $l): ?>
                    <div class="sub-card">
                        <div class="sub-top">
                            <div class="sub-name"><?= htmlspecialchars($l['nama_paket']) ?></div>
                            <span class="sub-badge" style="background:<?= $status_bg[$l['status']] ?? '#eee' ?>;color:<?= $status_color[$l['status']] ?? '#333' ?>">
                                <?= ucfirst($l['status']) ?>
                            </span>
                        </div>
                        <div class="sub-detail">
                            <i class="bi bi-lightning-charge-fill" style="color:#FAA18F;"></i>
                            <?= htmlspecialchars($l['speed']) ?>
                            &nbsp;·&nbsp;
                            <i class="bi bi-credit-card" style="color:#FAA18F;"></i>
                            <?= ucfirst($l['metode_bayar'] ?? '—') ?>
                            &nbsp;·&nbsp;
                            <?= date('d M Y', strtotime($l['created_at'])) ?>
                        </div>
                        <div class="sub-harga">Rp <?= number_format($l['harga'], 0, ',', '.') ?> / bulan</div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <a href="../php/auth/logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>

    </div>
</body>
</html>
