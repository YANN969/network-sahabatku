<?php
session_start();
require_once 'php/config/config.php';
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabatku — Penyedia Layanan Internet Terpercaya</title>
    <link rel="stylesheet" href="./css/sahabatku.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="./assets/logo 1.png" type="image/x-icon">
</head>

<body>

    <!-- Navbar -->
    <header class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="index.php" class="navbar-logo"><img src="./assets/sahabatku-logo.png" alt="Sahabatku"></a>
            <nav class="nav-menu" id="nav-menu" aria-label="Navigasi utama">
                <a href="#beranda">Beranda</a>
                <a href="#tentang">Tentang</a>
                <a href="#paket">Paket</a>
                <a href="#galeri">Galeri</a>
                <a href="#kontak">Kontak</a>

                <!-- Blok otentikasi untuk MOBILE -->
                <div class="navbar-auth">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="nav-profile">
                            <div class="nav-avatar">
                                <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
                            </div>
                            <div class="nav-dropdown">
                                <div class="nav-dropdown-header">
                                    <div class="dd-name"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                                    <div class="dd-email"><?= htmlspecialchars($_SESSION['email']) ?></div>
                                </div>
                                <hr>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <a href="page/admin-dashboard.php"><i class="bi bi-house-fill"></i> Dashboard Admin</a>
                                <?php else: ?>
                                    <a href="page/user-profile.php"><i class="bi bi-person-circle"></i> Profil Saya</a>
                                <?php endif; ?>
                                <a href="php/auth/logout.php" class="dd-logout"><i class="bi bi-box-arrow-right"></i> Keluar</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="php/auth/login.php" class="btn-login">Masuk</a>
                        <a href="php/auth/register.php" class="btn-register">Daftar</a>
                    <?php endif; ?>
                </div>
            </nav>
            <div class="navbar-auth" id="navbar-auth">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="nav-profile">
                        <div class="nav-avatar" id="nav-avatar">
                            <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
                        </div>
                        <div class="nav-dropdown" id="nav-dropdown">
                            <div class="nav-dropdown-header">
                                <div class="dd-name"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                                <div class="dd-email"><?= htmlspecialchars($_SESSION['email']) ?></div>
                            </div>
                            <hr>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="page/admin-dashboard.php"><i class="bi bi-house-fill"></i> Dashboard Admin</a>
                            <?php else: ?>
                                <a href="page/user-profile.php"><i class="bi bi-person-circle"></i> Profil Saya</a>
                            <?php endif; ?>
                            <a href="php/auth/logout.php" class="dd-logout"><i class="bi bi-box-arrow-right"></i> Keluar</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="php/auth/login.php" class="btn-login">Masuk</a>
                    <a href="php/auth/register.php" class="btn-register">Daftar</a>
                <?php endif; ?>
            </div>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false"
                aria-controls="nav-menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- Hero Slider -->
    <section class="hero" id="beranda" aria-label="Hero slider">
        <div class="slider-wrapper">
            <div class="slider-track" id="slider-track">
                <div class="slide" role="group" aria-label="Slide 1 dari 3">
                    <div class="slide-content">
                        <h1>Selamat Datang di <span class="accent">Sahabatku</span></h1>
                        <p>Internet cepat, stabil, dan harga terjangkau untuk semua kebutuhan Anda</p>
                    </div>
                </div>
                <div class="slide" role="group" aria-label="Slide 2 dari 3">
                    <div class="slide-content">
                        <h1>Dukungan <span class="accent">24/7</span></h1>
                        <p>Tim support siap membantu Anda kapan saja, tanpa hari libur</p>
                    </div>
                </div>
                <div class="slide" role="group" aria-label="Slide 3 dari 3">
                    <div class="slide-content">
                        <h1>Koneksi <span class="accent">Tanpa Batas</span></h1>
                        <p>Nikmati pengalaman internet terbaik dengan kecepatan tinggi dan stabil</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-dots" id="slider-dots" role="tablist" aria-label="Navigasi slide">
            <button class="dot" role="tab" aria-selected="false" aria-label="Slide 1" data-index="0"></button>
            <button class="dot" role="tab" aria-selected="false" aria-label="Slide 2" data-index="1"></button>
            <button class="dot" role="tab" aria-selected="false" aria-label="Slide 3" data-index="2"></button>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="section about" id="tentang">
        <div class="container fade-in">
            <div class="about-text" style="max-width:700px; margin:0 auto; text-align:center;">
                <h2>Tentang <span class="accent">Kami</span></h2>
                <p style="margin-bottom:16px;">Sahabatku adalah penyedia layanan internet terpercaya dengan koneksi
                    cepat, stabil, dan harga terjangkau. Kami hadir untuk memastikan setiap rumah dan bisnis di
                    Cimanggis Depok dapat menikmati internet berkualitas tinggi.</p>
                <p>Dengan pengalaman bertahun-tahun dan tim teknisi profesional, kami berkomitmen memberikan layanan
                    terbaik dan dukungan 24/7 kepada seluruh pelanggan kami.</p>
            </div>
        </div>
    </section>

    <!-- Paket Internet -->
    <section class="section paket" id="paket">
        <div class="container">
            <h2 class="section-title">Paket <span class="accent">Internet</span></h2>
            <p class="section-subtitle">Pilih paket yang sesuai dengan kebutuhan Anda</p>
            <div class="paket-grid fade-in" id="paket-grid">
                <?php
                $hasil = $conn->query('SELECT * FROM pakets ORDER BY id DESC');
                while ($p = $hasil->fetch_assoc()):
                    $fitur_list = array_map('trim', explode(',', $p['fitur']));
                    ?>
                    <div class="paket-card <?= $p['is_popular'] ? 'popular' : '' ?>">
                        <?php if ($p['is_popular']): ?><span class="badge-popular">Populer</span><?php endif; ?>
                        <h3 class="paket-name"><?= htmlspecialchars($p['nama']) ?></h3>
                        <div class="paket-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></div>
                        <div class="paket-period">/Bulan</div>
                        <div class="paket-speed"><?= htmlspecialchars($p['speed']) ?></div>
                        <ul class="paket-features">
                            <?php foreach ($fitur_list as $f): ?>
                                <li><?= htmlspecialchars($f) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="page/langganan.php?paket_id=<?= $p['id'] ?>"
                            class="btn <?= $p['is_popular'] ? 'btn-primary' : 'btn-outline' ?>">Pilih Paket</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    
    <!-- Galeri -->
    <section class="section galeri" id="galeri">
        <div class="container">
            <h2 class="section-title">Galeri <span class="accent">Kami</span></h2>
            <p class="section-subtitle">Dokumentasi kegiatan dan fasilitas Sahabatku</p>
            <div class="galeri-grid fade-in">
                <?php
                $hasil = $conn->query('SELECT * FROM galeri ORDER BY id ASC LIMIT 6');
                while ($g = $hasil->fetch_assoc()):
                    ?>
                    <div class="galeri-item">
                        <?php if ($g['img_path']): ?>
                            <img src="<?= htmlspecialchars($g['img_path']) ?>" alt="<?= htmlspecialchars($g['judul']) ?>">
                        <?php else: ?>
                            <div class="galeri-placeholder"><i class="bi bi-image" style="font-size:2rem"></i></div>
                        <?php endif; ?>
                        <div class="galeri-overlay">
                            <h4><?= htmlspecialchars($g['judul']) ?></h4>
                            <p><?= htmlspecialchars($g['deskripsi']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section class="section kontak" id="kontak">
        <div class="container">
            <h2 class="section-title">Hubungi <span class="accent">Kami</span></h2>
            <p class="section-subtitle">Kami siap membantu Anda 24/7</p>
            <div class="kontak-cards fade-in">
                <div class="kontak-card">
                    <div class="kontak-card-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <h4>Alamat</h4>
                    <p>Jl. Kamboja No.50<br>Cimanggis, Depok</p>
                </div>
                <div class="kontak-card">
                    <div class="kontak-card-icon"><i class="bi bi-telephone-fill"></i></div>
                    <h4>Telepon</h4>
                    <p>0895-3339-53073</p>
                </div>
                <div class="kontak-card">
    <div class="kontak-card-icon"><i class="bi bi-whatsapp"></i></div>
    <h4>WhatsApp</h4>
    <p>Chat langsung dengan tim kami</p>
    <a href="https://wa.me/62895333953073?text=Halo%20admin,%20saya%20ingin%20tanya%20layanan%20internet%20Sahabatku" 
       target="_blank" 
       rel="noopener" 
       class="kontak-card-link">
       Buka WhatsApp
    </a>
</div>
                <div class="kontak-card">
                    <div class="kontak-card-icon"><i class="bi bi-clock-fill"></i></div>
                    <h4>Jam Operasional</h4>
                    <p>24/7 — Setiap hari<br>tanpa hari libur</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>Tentang Sahabatku</h3>
                    <p>Sahabatku adalah penyedia layanan internet terpercaya dengan koneksi cepat, stabil, dan harga
                        terjangkau.</p>
                    <div class="footer-socials">
                        <a href="https://wa.me/62895333953073?text=Halo%20admin,%20saya%20ingin%20tanya%20layanan%20internet%20Sahabatku" 
                    target="_blank" 
                    rel="noopener"
                    class="footer-social-icon">
                    <i class="bi bi-whatsapp"></i>
                    </a>
                        <a href="https://www.instagram.com/sahabatku_company16?igsh=cTRlaGVuZjVjZ2gy" target="_blank" rel="noopener" class="footer-social-icon"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Link Cepat</h4>
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#paket">Paket Internet</a></li>
                        <li><a href="#galeri">Galeri</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="#" onclick="openModal('modal-faq'); return false;">FAQ</a></li>
                        <li><a href="#" onclick="openModal('modal-syarat'); return false;">Syarat &amp; Ketentuan</a>
                        </li>
                        <li><a href="#" onclick="openModal('modal-privasi'); return false;">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Kontak Kami</h4>
                    <ul class="footer-kontak-list">
                        <li><span class="footer-kontak-icon"><i class="bi bi-telephone-fill"></i></span><span>0895-3339-53073</span></li>
                        <li><span class="footer-kontak-icon"><i class="bi bi-envelope-fill"></i></span><span>info@sahabatku.net</span></li>
                        <li><span class="footer-kontak-icon"><i class="bi bi-geo-alt-fill"></i></span><span>Jl. Kamboja No.50, Cimanggis Depok</span>
                        </li>
                    </ul>
                    <div class="footer-maps" style="margin-top:16px">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.36290524692!2d106.85092087370192!3d-6.34703176209403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec502bdf2473%3A0x884ec94febc9ad34!2sJl.%20Kamboja%20No.50%2C%20Tugu%2C%20Kec.%20Cimanggis%2C%20Kota%20Depok%2C%20Jawa%20Barat%2016451%2C%20Indonesia!5e0!3m2!1sen!2sus!4v1776754035647!5m2!1sen!2sus"
                            allowfullscreen="" loading="lazy" title="Lokasi Sahabatku"></iframe>
                            
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Sahabatku. All rights reserved.</p>
        </div>
    </footer>
    
    
    <!-- Whatsapp Logo Floating -->
 <a href="https://wa.me/62895333953073?text=Halo%20admin,%20saya%20ingin%20tanya%20layanan%20internetnya"
    target="_blank" rel="noopener" class="wa-float">
    <i class="bi bi-whatsapp"></i> 
    <span>Chat Kami</span>
    </a>

    <!-- Modal FAQ -->
    <div class="legal-modal-overlay" id="modal-faq" onclick="closeLegalModal(event,'modal-faq')">
        <div class="legal-modal">
            <div class="legal-modal-header">
                <h2>FAQ <span class="accent">(Pertanyaan Umum)</span></h2>
                <button class="legal-modal-close" onclick="closeModal('modal-faq')">✕</button>
            </div>
            <div class="legal-modal-body" id="faq-modal-list"></div>
        </div>
    </div>

    <!-- Modal Syarat -->
    <div class="legal-modal-overlay" id="modal-syarat" onclick="closeLegalModal(event,'modal-syarat')">
        <div class="legal-modal">
            <div class="legal-modal-header">
                <h2>Syarat &amp; <span class="accent">Ketentuan</span></h2>
                <button class="legal-modal-close" onclick="closeModal('modal-syarat')">✕</button>
            </div>
            <div class="legal-modal-body">
                <p>Terakhir diperbarui: Januari 2026</p>
                <div class="ketentuan-umum">
                    <h3>1. Ketentuan Umum</h3>
                    <p>Dengan mendaftar dan menggunakan layanan Sahabatku, Anda setuju untuk terikat dengan syarat dan ketentuan berikut:</p>
                        <p>• Pelanggan harus berusia minimal 17 tahun atau memiliki izin dari orang tua/wali.</p>
                        <p>• Pelanggan bertanggung jawab atas semua aktivitas yang terjadi melalui akunnya.</p>
                        <p>• Sahabatku berhak mengubah syarat dan ketentuan dengan pemberitahuan terlebih dahulu.</p>
                </div>
                <div class="pembayaran">
                    <h3>2. Pembayaran</h3>
                    <p>• Pembayaran dilakukan di awal setiap bulan sesuai paket yang dipilih.</p>
                    <p>• Pembayaran dapat dilakukan melalui transfer bank, e-wallet, atau kartu kredit.</p> 
                    <p>• Bukti pembayaran harus disimpan sebagai referensi.</p>
                </div>
                <div class="penggunaan-layanan">
                    <h3>3. Penggunaan Layanan</h3>
                    <p>• Layanan hanya untuk penggunaan pribadi/rumah tangga, tidak untuk komersial tanpa izin.</p>
                    <p>• Dilarang menggunakan layanan untuk aktivitas ilegal atau melanggar hukum.</p>
                    <p>• Dilarang menjual kembali atau berbagi akses dengan pihak ketiga tanpa izin.</p>
                    <p>• Sahabatku berhak memblokir akses jika ditemukan penyalahgunaan.</p>
                </div>
                <div class="gangguan-layanan">
                    <h3>4. Gangguan Layanan</h3>
                    <p>• Sahabatku akan berusaha meminimalkan gangguan layanan.</p>
                    <p>• Gangguan karena force majeure di luar kendali kami tidak menjadi tanggung jawab kami.</p>
                    <p>• Kompensasi akan diberikan untuk gangguan lebih dari 24 jam berturut-turut.</p>
                </div>
                <div class="privasi&data">
                    <h3>5. Privasi dan Data</h3>
                    <p>• Data pelanggan akan dijaga kerahasiaannya sesuai kebijakan privasi.</p>
                    <p>• Kami dapat menggunakan data untuk peningkatan layanan dengan tetap menjaga privasi.</p>
                    <p>• Pelanggan berhak mengakses dan memperbaiki data pribadinya.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Privasi -->
    <div class="legal-modal-overlay" id="modal-privasi" onclick="closeLegalModal(event,'modal-privasi')">
        <div class="legal-modal">
            <div class="legal-modal-header">
                <h2>Kebijakan <span class="accent">Privasi</span></h2>
                <button class="legal-modal-close" onclick="closeModal('modal-privasi')">✕</button>
            </div>
            <div class="legal-modal-body">
                <p>Terakhir diperbarui: Januari 2026</p>
                <h3>Informasi yang kami kumpulkam</h3>
                <h5>Kami mengumpulkan informasi berikut :</h5>
                <p>• Informasi pribadi: nama, alamat, email, nomor telepon</p>
                <p>• Informasi pembayaran: data transaksi, riwayat pembayaran</p>
                <p>• Informasi teknis: alamat IP, data penggunaan, jenis perangkat</p>
                <p>• Komunikasi: riwayat chat, email, panggilan dengan customer service</p>

                <h3>Penggunaan Informasi</h3>
                <h5>Informasi Anda digunakan untuk :</h5>
                <p>• Memproses pendaftaran dan pembayaran</p>
                <p>• Memberikan layanan dan dukungan pelanggan</p>
                <p>• Meningkatkan kualitas layanan</p>
                <p>• Mengirimkan informasi promo dan pembaruan</p>
                <p>• Mencegah penipuan dan penyalahgunaan</p>
            </div>
        </div>
    </div>

    <script src="./js/sahabatku.js"></script>
    <script>
        var avatar = document.getElementById('nav-avatar');
        if (avatar) {
            avatar.addEventListener('click', function (e) {
                e.stopPropagation();
                document.getElementById('nav-dropdown').classList.toggle('open');
            });
            document.addEventListener('click', function () {
                var dd = document.getElementById('nav-dropdown');
                if (dd) dd.classList.remove('open');
            });
        }
    </script>

</body>
</html>