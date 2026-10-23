<?php
// create_db.php
// Jalankan sekali via browser: http://localhost/Capstone/create_db.php
// Setelah berhasil: HAPUS file ini.

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke MySQL (sesuaikan user/password kalau beda)
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$port = 8111; // pake port MySQL di XAMPP-mu

// Nama database baru (ganti kalau mau)
$dbname = 'deteksi_stoberi_new';

$koneksi = mysqli_connect($host, $user, $pass, '', $port);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 1) Buat database baru (hapus jika sudah ada)
$sql = "DROP DATABASE IF EXISTS `$dbname`";
if (!mysqli_query($koneksi, $sql)) {
    die("Gagal drop DB: " . mysqli_error($koneksi));
}

$sql = "CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (!mysqli_query($koneksi, $sql)) {
    die("Gagal buat DB: " . mysqli_error($koneksi));
}

echo "Database `$dbname` berhasil dibuat.<br>";

// Pilih database baru
mysqli_select_db($koneksi, $dbname);

// 2) Buat tabel users
$sql_users = "
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    level ENUM('Admin','User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
if (!mysqli_query($koneksi, $sql_users)) {
    die("Gagal buat tabel users: " . mysqli_error($koneksi));
}
echo "Tabel `users` berhasil dibuat.<br>";

// 3) Buat tabel riwayat_deteksi
$sql_history = "
CREATE TABLE riwayat_deteksi (
    id_riwayat INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    hasil VARCHAR(100) NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
if (!mysqli_query($koneksi, $sql_history)) {
    die("Gagal buat tabel riwayat_deteksi: " . mysqli_error($koneksi));
}
echo "Tabel `riwayat_deteksi` berhasil dibuat.<br>";

// 4) Tambah akun admin dan contoh user (password di-hash)
$admin_user = 'admin';
$admin_pass = password_hash('admin123', PASSWORD_DEFAULT);

$user1 = 'doni';
$user1_pass = password_hash('doni123', PASSWORD_DEFAULT);

$user2 = 'era';
$user2_pass = password_hash('era123', PASSWORD_DEFAULT);

$ins = "INSERT INTO users (username, password, level) VALUES
('$admin_user', '$admin_pass', 'Admin'),
('$user1', '$user1_pass', 'User'),
('$user2', '$user2_pass', 'User')";
if (!mysqli_query($koneksi, $ins)) {
    die("Gagal insert akun: " . mysqli_error($koneksi));
}
echo "Akun contoh berhasil dibuat (admin/doni/era).<br>";

// Selesai
echo "<br><strong>Selesai.</strong><br>";
echo "1) Ubah koneksi (koneksi.php) agar memakai database: <code>$dbname</code> dan port <code>$port</code>.<br>";
echo "2) Hapus file ini (<code>create_db.php</code>) setelah selesai untuk keamanan.<br>";
echo "<br>Contoh koneksi yang harus dipakai di koneksi.php:<br>";
echo "<pre>
&lt;?php
$koneksi = mysqli_connect('127.0.0.1', 'root', '', '$dbname', $port);
if (mysqli_connect_errno()) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?&gt;
</pre>";

mysqli_close($koneksi);
?>

