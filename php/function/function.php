<?php
// Paket

function tambahPaket($conn) {
    $nama       = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $harga      = (int)$_POST['harga'];
    $speed      = mysqli_real_escape_string($conn, trim($_POST['speed']));
    $fitur      = mysqli_real_escape_string($conn, trim($_POST['fitur']));
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    mysqli_query($conn, "INSERT INTO pakets (nama,harga,speed,fitur,is_popular) VALUES ('$nama',$harga,'$speed','$fitur',$is_popular)");
    return mysqli_affected_rows($conn);
}

function ubahPaket($conn) {
    $id         = (int)$_POST['id'];
    $nama       = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $harga      = (int)$_POST['harga'];
    $speed      = mysqli_real_escape_string($conn, trim($_POST['speed']));
    $fitur      = mysqli_real_escape_string($conn, trim($_POST['fitur']));
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    mysqli_query($conn, "UPDATE pakets SET nama='$nama',harga=$harga,speed='$speed',fitur='$fitur',is_popular=$is_popular WHERE id=$id");
    return mysqli_affected_rows($conn);
}

function hapusPaket($conn) {
    $id = (int)$_POST['id'];
    mysqli_query($conn, "DELETE FROM pakets WHERE id=$id");
    return mysqli_affected_rows($conn);
}

// Galeri

function uploadGambar($base_path = '../assets/') {
    if (empty($_FILES['gambar']['name'])) return ['sukses' => false, 'pesan' => 'File tidak ditemukan'];
    $file = $_FILES['gambar'];
    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','webp'])) return ['sukses' => false, 'pesan' => 'Format tidak didukung'];
    if ($file['size'] > 2 * 1024 * 1024) return ['sukses' => false, 'pesan' => 'Ukuran maksimal 2MB'];
    $nama_file = 'galeri_' . time() . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], $base_path . $nama_file)) {
        return ['sukses' => true, 'img_path' => 'assets/' . $nama_file];
    }
    return ['sukses' => false, 'pesan' => 'Upload gagal'];
}

function tambahGaleri($conn, $img_path = '') {
    $judul     = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
    $img_path  = mysqli_real_escape_string($conn, $img_path);
    mysqli_query($conn, "INSERT INTO galeri (judul,deskripsi,img_path) VALUES ('$judul','$deskripsi','$img_path')");
    return mysqli_affected_rows($conn);
}

function ubahGaleri($conn, $img_path = '') {
    $id        = (int)$_POST['id'];
    $judul     = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
    $img_path  = mysqli_real_escape_string($conn, $img_path);
    mysqli_query($conn, "UPDATE galeri SET judul='$judul',deskripsi='$deskripsi',img_path='$img_path' WHERE id=$id");
    return mysqli_affected_rows($conn);
}

function hapusGaleri($conn) {
    $id  = (int)$_POST['id'];
    $res = mysqli_query($conn, "SELECT img_path FROM galeri WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if ($row && $row['img_path'] && file_exists('../' . $row['img_path'])) {
        unlink('../' . $row['img_path']);
    }
    mysqli_query($conn, "DELETE FROM galeri WHERE id=$id");
    return mysqli_affected_rows($conn);
}

// Langganan

function ubahStatusLangganan($conn) {
    $id     = (int)$_POST['id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE langganan SET status='$status' WHERE id=$id");
    return mysqli_affected_rows($conn);
}

function hapusLangganan($conn) {
    $id = (int)$_POST['id'];
    mysqli_query($conn, "DELETE FROM langganan WHERE id=$id");
    return mysqli_affected_rows($conn);
}

// Auth

function login($data) {
    global $conn;
    $email    = $data['email'];
    $password = $data['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['login']   = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama']    = $row['nama'];
            $_SESSION['email']   = $row['email'];
            $_SESSION['role']    = $row['role'];
            return true;
        }
    }
    return false;
}

function register($data) {
    global $conn;
    $nama      = htmlspecialchars($data['nama']);
    $email     = htmlspecialchars($data['email']);
    $telepon   = htmlspecialchars($data['telepon']);
    $alamat    = htmlspecialchars($data['alamat']);
    $password  = $data['password'];
    $password2 = $data['confirm_password'];

    
    $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_fetch_assoc($result)) { 
        echo "<script>alert('Email sudah terdaftar');</script>"; 
        return 0; 
    }

    
    if ($password !== $password2) { 
        echo "<script>alert('Konfirmasi Password salah');</script>"; 
        return 0; 
    }

    
    $password = password_hash($password, PASSWORD_DEFAULT);

    
    mysqli_query($conn, "INSERT INTO users (nama, email, password, telepon, alamat, role)
                         VALUES ('$nama', '$email', '$password', '$telepon', '$alamat', 'user')");
    return mysqli_affected_rows($conn);
}

// Pengguna

function tambahPengguna($conn) {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $telepon  = mysqli_real_escape_string($conn, trim($_POST['telepon'] ?? ''));
    $alamat   = mysqli_real_escape_string($conn, trim($_POST['alamat'] ?? ''));
    $role     = $_POST['role'] === 'admin' ? 'admin' : 'user';
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    mysqli_query($conn, "INSERT INTO users (nama,email,password,telepon,alamat,role) VALUES ('$nama','$email','$password','$telepon','$alamat','$role')");
    return mysqli_affected_rows($conn);
}

function ubahPengguna($conn) {
    $id      = (int)$_POST['id'];
    $nama    = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $telepon = mysqli_real_escape_string($conn, trim($_POST['telepon'] ?? ''));
    $alamat  = mysqli_real_escape_string($conn, trim($_POST['alamat'] ?? ''));
    $role    = $_POST['role'] === 'admin' ? 'admin' : 'user';
    mysqli_query($conn, "UPDATE users SET nama='$nama',telepon='$telepon',alamat='$alamat',role='$role' WHERE id=$id");
    return mysqli_affected_rows($conn);
}

function hapusPengguna($conn) {
    $id = (int)$_POST['id'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    return mysqli_affected_rows($conn);
}

// Ambil Data

function ambilPaket($conn) {
    $res = mysqli_query($conn, "SELECT * FROM pakets ORDER BY harga ASC");
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
    return $data;
}

function ambilGaleri($conn) {
    $res = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id ASC");
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
    return $data;
}

function ambilLangganan($conn) {
    $res = mysqli_query($conn, "
        SELECT l.*, u.nama AS nama_user, p.nama AS nama_paket
        FROM langganan l
        JOIN users u ON l.user_id = u.id
        JOIN pakets p ON l.paket_id = p.id
        ORDER BY l.created_at DESC
    ");
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
    return $data;
}

function ambilPengguna($conn) {
    $res = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
    return $data;
}

// Ajukan Langganan

function ajukanLangganan($conn, $user_id, $paket_id, $data) {
    $nama         = mysqli_real_escape_string($conn, trim($data['nama']));
    $telepon      = mysqli_real_escape_string($conn, trim($data['telepon']));
    $alamat       = mysqli_real_escape_string($conn, trim($data['alamat']));
    $catatan      = mysqli_real_escape_string($conn, trim($data['catatan'] ?? ''));
    $metode_bayar = mysqli_real_escape_string($conn, trim($data['metode_bayar'] ?? 'transfer'));
    mysqli_query($conn, "INSERT INTO langganan (user_id, paket_id, nama, telepon, alamat, catatan, metode_bayar)
                         VALUES ($user_id, $paket_id, '$nama', '$telepon', '$alamat', '$catatan', '$metode_bayar')");
    return mysqli_affected_rows($conn);
}
