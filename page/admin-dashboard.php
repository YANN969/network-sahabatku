<?php
session_start();
if (empty($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../php/auth/login.php');
    exit;
}
require_once '../php/config/config.php';
require_once '../php/function/function.php';

$pesan = '';
$aksi = $_POST['aksi'] ?? '';

// Paket
if ($aksi === 'tambah_paket') {
    tambahPaket($conn);
    $pesan = 'Paket berhasil ditambahkan.';
}
if ($aksi === 'ubah_paket') {
    ubahPaket($conn);
    $pesan = 'Paket berhasil diubah.';
}
if ($aksi === 'hapus_paket') {
    hapusPaket($conn);
    $pesan = 'Paket berhasil dihapus.';
}

// Galeri
if ($aksi === 'tambah_galeri' || $aksi === 'ubah_galeri') {
    $img_path = $_POST['img_path_lama'] ?? '';
    if (!empty($_FILES['gambar']['name'])) {
        $upload = uploadGambar('../assets/');
        if ($upload['sukses']) {
            $img_path = $upload['img_path'];
        } else {
            $pesan = $upload['pesan'];
        }
    }
    if (!$pesan) {
        if ($aksi === 'tambah_galeri') {
            tambahGaleri($conn, $img_path);
            $pesan = 'Item galeri berhasil ditambahkan.';
        } else {
            ubahGaleri($conn, $img_path);
            $pesan = 'Item galeri berhasil diubah.';
        }
    }
}
if ($aksi === 'hapus_galeri') {
    hapusGaleri($conn);
    $pesan = 'Item galeri berhasil dihapus.';
}

// Langganan
if ($aksi === 'ubah_status') {
    ubahStatusLangganan($conn);
    $pesan = 'Status berhasil diubah.';
}
if ($aksi === 'hapus_langganan') {
    hapusLangganan($conn);
    $pesan = 'Pengajuan berhasil dihapus.';
}

// Pengguna
if ($aksi === 'hapus_pengguna') {
    if ((int) $_POST['id'] !== (int) $_SESSION['user_id']) {
        hapusPengguna($conn);
        $pesan = 'Pengguna berhasil dihapus.';
    } else {
        $pesan = 'Tidak dapat menghapus akun sendiri.';
    }
}

// Ambil data
$tab = $_GET['tab'] ?? 'beranda';

$pakets = ambilPaket($conn);
$galeris = ambilGaleri($conn);
$langganan = ambilLangganan($conn);
$pengguna = ambilPengguna($conn);

$jml_user = count($pengguna);
$jml_paket = count($pakets);
$jml_galeri = count($galeris);
$jml_sub = count($langganan);

$edit_paket = null;
$edit_galeri = null;
if (isset($_GET['edit_paket'])) {
    foreach ($pakets as $p) {
        if ($p['id'] == (int) $_GET['edit_paket']) {
            $edit_paket = $p;
            break;
        }
    }
}
if (isset($_GET['edit_galeri'])) {
    foreach ($galeris as $g) {
        if ($g['id'] == (int) $_GET['edit_galeri']) {
            $edit_galeri = $g;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Sahabatku</title>
    <link rel="stylesheet" href="../css/sahabatku-admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../assets/logo 1.png" type="image/x-icon">
    <style>
        .pesan {
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px
        }

        th,
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: middle
        }

        th {
            background: #f8f8f8;
            font-weight: 600
        }

        .badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600
        }

        .badge-success {
            background: #d4edda;
            color: #155724
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .07)
        }

        .card h2 {
            font-size: 16px;
            margin-bottom: 16px
        }

        .form-group {
            margin-bottom: 14px
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box
        }

        .btn {
            padding: 7px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block
        }

        .btn-primary {
            background: #e74c3c;
            color: #fff
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff
        }

        .btn-danger {
            background: #dc3545;
            color: #fff
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 12px
        }

        .grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 16px
        }

        img.thumb {
            width: 60px;
            height: 45px;
            object-fit: cover;
            border-radius: 4px
        }
    </style>
</head>

<body>
    <!-- Utama -->
    <div class="dashboard-wrapper">
        <aside class="sidebar">
            <div class="sidebar-logo"><a href="../index.php">Sahabatku</a>
                <p>Panel Admin</p>
            </div>
            <nav class="sidebar-nav">
                <a href="?tab=beranda" <?= $tab === 'beranda' ? 'class="active"' : '' ?>><i class="bi bi-house-fill"></i> Beranda</a>
                <a href="?tab=paket" <?= $tab === 'paket' ? 'class="active"' : '' ?>><i class="bi bi-box-seam"></i> Kelola Paket</a>
                <a href="?tab=galeri" <?= $tab === 'galeri' ? 'class="active"' : '' ?>><i class="bi bi-image"></i> Kelola Galeri</a>
                <a href="?tab=langganan" <?= $tab === 'langganan' ? 'class="active"' : '' ?>><i class="bi bi-clipboard-check"></i> Pengajuan</a>
                <a href="?tab=pengguna" <?= $tab === 'pengguna' ? 'class="active"' : '' ?>><i class="bi bi-people-fill"></i> Pengguna</a>
            </nav>
            
            <div class="sidebar-footer"><a href="../php/auth/logout.php"><i class="bi bi-box-arrow-right"></i> Keluar</a></div>
        </aside>

        <div class="dashboard-main">
            <header class="dashboard-topbar">
                <span class="topbar-title"><?= ucfirst($tab) ?></span>
                <div class="topbar-user">
                    <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
                    <div class="avatar"><?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?></div>
                </div>
            </header>

            <div class="dashboard-content">
                <?php if ($pesan): ?>
                    <div class="pesan"><?= htmlspecialchars($pesan) ?></div>
                <?php endif; ?>

                <?php if ($tab === 'beranda'): ?>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-people"></i></div>
                            <div class="stat-label">Total Pengguna</div>
                            <div class="stat-value"><?= $jml_user ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
                            <div class="stat-label">Total Paket</div>
                            <div class="stat-value"><?= $jml_paket ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-image"></i></div>
                            <div class="stat-label">Item Galeri</div>
                            <div class="stat-value"><?= $jml_galeri ?></div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-clipboard-check"></i></div>
                            <div class="stat-label">Total Pengajuan</div>
                            <div class="stat-value"><?= $jml_sub ?></div>
                        </div>
                    </div>
                    <div class="card">
                        <h2>Pengajuan Terbaru</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Paket</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $w = ['menunggu' => 'warning', 'diproses' => 'info', 'aktif' => 'success', 'ditolak' => 'danger', 'dibatalkan' => 'danger'];
                                foreach (array_slice($langganan, 0, 5) as $l): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($l['nama_user']) ?></td>
                                        <td><?= htmlspecialchars($l['nama_paket']) ?></td>
                                        <td><?= substr($l['created_at'], 0, 10) ?></td>
                                        <td><span class="badge badge-<?= $w[$l['status']] ?? 'info' ?>"><?= $l['status'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <!-- paket -->
                <?php elseif ($tab === 'paket'): ?>
                    <div class="card">
                        <h2><?= $edit_paket ? 'Edit Paket' : 'Tambah Paket' ?></h2>
                        <form method="POST" action="?tab=paket">
                            <input type="hidden" name="aksi" value="<?= $edit_paket ? 'ubah_paket' : 'tambah_paket' ?>">
                            <?php if ($edit_paket): ?><input type="hidden" name="id"
                                    value="<?= $edit_paket['id'] ?>"><?php endif; ?>
                            <div class="grid2">
                                <div class="form-group"><label>Nama Paket</label>
                                    <input type="text" name="nama" value="<?= htmlspecialchars($edit_paket['nama'] ?? '') ?>"
                                        required>
                                </div>
                                <div class="form-group"><label>Harga (Rp)</label>
                                    <input type="number" name="harga" value="<?= $edit_paket['harga'] ?? '' ?>" required>
                                </div>
                                <div class="form-group"><label>Kecepatan</label>
                                    <input type="text" name="speed"
                                        value="<?= htmlspecialchars($edit_paket['speed'] ?? '') ?>" placeholder="30 Mbps"
                                        required>
                                </div>
                                <div class="form-group"><label>Fitur (pisahkan koma)</label>
                                    <input type="text" name="fitur"
                                        value="<?= htmlspecialchars($edit_paket['fitur'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="form-group checkbox-group">
                                <label><input type="checkbox" name="is_popular" value="1" <?= !empty($edit_paket['is_popular']) ? 'checked' : '' ?>> Tandai sebagai Populer</label>
                            </div>
                            <button type="submit"
                                class="btn btn-primary"><?= $edit_paket ? 'Simpan Perubahan' : 'Tambah Paket' ?></button>
                            <?php if ($edit_paket): ?>
                                <a href="?tab=paket" class="btn btn-secondary" style="margin-left:8px">Batal</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="card">
                        <h2>Daftar Paket</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Kecepatan</th>
                                    <th>Fitur</th>
                                    <th>Populer</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pakets as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['nama']) ?></td>
                                        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($p['speed']) ?></td>
                                        <td style="font-size:12px;color:#666"><?= htmlspecialchars($p['fitur']) ?></td>
                                        <td><?= $p['is_popular'] ? '<span class="badge badge-success">Ya</span>' : 'Tidak' ?>
                                        </td>
                                        <td style="display:flex;gap:6px;flex-wrap:wrap">
                                            <a href="?tab=paket&edit_paket=<?= $p['id'] ?>" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                            <form method="POST" action="?tab=paket" style="display:inline"
                                                onsubmit="return confirm('Hapus paket ini?')">
                                                <input type="hidden" name="aksi" value="hapus_paket">
                                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <!-- galeri-->
                <?php elseif ($tab === 'galeri'): ?>
                    <div class="card">
                        <h2><?= $edit_galeri ? 'Edit Item Galeri' : 'Tambah Item Galeri' ?></h2>
                        <form method="POST" action="?tab=galeri" enctype="multipart/form-data">
                            <input type="hidden" name="aksi" value="<?= $edit_galeri ? 'ubah_galeri' : 'tambah_galeri' ?>">
                            <?php if ($edit_galeri): ?>
                                <input type="hidden" name="id" value="<?= $edit_galeri['id'] ?>">
                                <input type="hidden" name="img_path_lama"
                                    value="<?= htmlspecialchars($edit_galeri['img_path'] ?? '') ?>">
                            <?php endif; ?>
                            <div class="form-group"><label>Judul</label>
                                <input type="text" name="judul" value="<?= htmlspecialchars($edit_galeri['judul'] ?? '') ?>" required>
                            </div>
                            <div class="form-group"><label>Deskripsi</label>
                                <textarea name="deskripsi" rows="3"><?= htmlspecialchars($edit_galeri['deskripsi'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group"><label>Upload Gambar (opsional, maks 2MB)</label>
                                <input type="file" name="gambar" accept="image/*" <?= $edit_galeri ? '' : 'required' ?>>
                                <?php if (!empty($edit_galeri['img_path'])): ?>
                                    <img src="../<?= htmlspecialchars($edit_galeri['img_path']) ?>" class="thumb"
                                        style="margin-top:8px">
                                <?php endif; ?>
                            </div>
                            <button type="submit"
                                class="btn btn-primary"><?= $edit_galeri ? 'Simpan Perubahan' : 'Tambah Item' ?></button>
                            <?php if ($edit_galeri): ?>
                                <a href="?tab=galeri" class="btn btn-secondary" style="margin-left:8px">Batal</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="card">
                        <h2>Daftar Galeri</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($galeris as $g): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($g['judul']) ?></td>
                                        <td style="font-size:13px;color:#666"><?= htmlspecialchars($g['deskripsi']) ?></td>
                                        <td><?= $g['img_path'] ? '<img src="../' . htmlspecialchars($g['img_path']) . '" class="thumb">' : '—' ?>
                                        </td>
                                        <td style="display:flex;gap:6px">
                                            <a href="?tab=galeri&edit_galeri=<?= $g['id'] ?>"
                                                class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                            <form method="POST" action="?tab=galeri" style="display:inline"
                                                onsubmit="return confirm('Hapus item ini?')">
                                                <input type="hidden" name="aksi" value="hapus_galeri">
                                                <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <!-- langganan -->
                <?php elseif ($tab === 'langganan'): ?>
                    <div class="card">
                        <h2>Semua Pengajuan</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Paket</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $w = ['menunggu' => 'warning', 'diproses' => 'info', 'aktif' => 'success', 'ditolak' => 'danger', 'dibatalkan' => 'danger'];
                                foreach ($langganan as $l): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($l['nama_user']) ?></td>
                                        <td><?= htmlspecialchars($l['nama_paket']) ?></td>
                                        <td><?= htmlspecialchars($l['telepon']) ?></td>
                                        <td style="font-size:12px"><?= htmlspecialchars($l['alamat']) ?></td>
                                        <td><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $l['metode_bayar'] ?? '-'))) ?></td>
                                        <td><?= substr($l['created_at'], 0, 10) ?></td>
                                        <td><span class="badge badge-<?= $w[$l['status']] ?? 'info' ?>"><?= $l['status'] ?></span>
                                        </td>
                                        <td>
                                            <form method="POST" action="?tab=langganan"
                                                style="display:flex;gap:4px;align-items:center;flex-wrap:wrap">
                                                <input type="hidden" name="aksi" value="ubah_status">
                                                <input type="hidden" name="id" value="<?= $l['id'] ?>">
                                                <select name="status"
                                                    style="padding:4px 6px;border:1px solid #ddd;border-radius:4px;font-size:12px">
                                                    <?php foreach (['menunggu', 'diproses', 'aktif', 'ditolak', 'dibatalkan'] as $s): ?>
                                                        <option value="<?= $s ?>" <?= $l['status'] === $s ? 'selected' : '' ?>><?= $s ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                            </form>
                                            <form method="POST" action="?tab=langganan" style="display:inline;margin-top:4px"
                                                onsubmit="return confirm('Hapus pengajuan ini?')">
                                                <input type="hidden" name="aksi" value="hapus_langganan">
                                                <input type="hidden" name="id" value="<?= $l['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <!-- pengguna -->
                <?php elseif ($tab === 'pengguna'): ?>
                    <div class="card">
                        <h2>Daftar Pengguna</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pengguna as $u): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($u['nama']) ?></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td><?= htmlspecialchars($u['telepon'] ?? '—') ?></td>
                                        <td><span
                                                class="badge badge-<?= $u['role'] === 'admin' ? 'info' : 'success' ?>"><?= $u['role'] ?></span>
                                        </td>
                                        <td>
                                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                                <form method="POST" action="?tab=pengguna" style="display:inline"
                                                    onsubmit="return confirm('Hapus pengguna ini?')">
                                                    <input type="hidden" name="aksi" value="hapus_pengguna">
                                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                                </form>
                                            <?php else: ?>
                                                <span style="font-size:12px;color:#999">Akun Anda</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>

</html>