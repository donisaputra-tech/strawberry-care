<?php
session_start();
include "../Koneksi.php"; 

header("Content-Type: application/json");

// Ambil JSON dari fetch
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Data tidak diterima"]);
    exit;
}

// Validasi login
if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "User belum login"]);
    exit;
}

// Ambil data deteksi
$id_user     = $_SESSION['id_user'];
$hasil       = $data['label'];
$prob        = floatval($data['probability']);
$desc        = $data['description'];
$gambar      = $data['image_name'];
$penanganan  = $data['treatment'];   // ⬅️ PENANGANAN DITAMBAHKAN

// Query simpan
$sql = "INSERT INTO riwayat_deteksi (id_user, gambar, hasil, probability, deskripsi, penanganan)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "issdss", 
    $id_user, 
    $gambar, 
    $hasil, 
    $prob, 
    $desc,
    $penanganan   // ⬅️ MASUKKAN KE QUERY
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status" => "success", "message" => "Hasil deteksi disimpan"]);
} else {
    echo json_encode(["status" => "error", "message" => mysqli_error($koneksi)]);
}
?>
