<?php
session_start();
include "../Koneksi.php";

if (isset($_GET['id']) && isset($_SESSION['id_user'])) {
    $id_riwayat = $_GET['id'];
    $id_user = $_SESSION['id_user'];

    // Ambil nama gambar dulu untuk dihapus dari folder uploads (opsional tapi disarankan)
    $sql_file = "SELECT gambar FROM riwayat_deteksi WHERE id_riwayat = ? AND id_user = ?";
    $stmt_file = mysqli_prepare($koneksi, $sql_file);
    mysqli_stmt_bind_param($stmt_file, "ii", $id_riwayat, $id_user);
    mysqli_stmt_execute($stmt_file);
    $result_file = mysqli_stmt_get_result($stmt_file);
    
    if ($row = mysqli_fetch_assoc($result_file)) {
        $path = "../uploads/" . $row['gambar'];
        if (file_exists($path)) {
            unlink($path); // Menghapus file gambar fisik
        }
    }

    // Hapus data dari database
    $sql_delete = "DELETE FROM riwayat_deteksi WHERE id_riwayat = ? AND id_user = ?";
    $stmt_delete = mysqli_prepare($koneksi, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "ii", $id_riwayat, $id_user);
    
    if (mysqli_stmt_execute($stmt_delete)) {
        header("Location: profil.php?status=deleted");
    } else {
        header("Location: profil.php?status=error");
    }
} else {
    header("Location: profil.php");
}
exit;