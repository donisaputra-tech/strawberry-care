<?php
// 1. Mengatur header agar browser/JavaScript tahu bahwa responsnya adalah JSON
header('Content-Type: application/json');

$target_dir = "uploads/";

// Memastikan folder 'uploads' ada
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Cek apakah file benar-benar diunggah dan tidak ada error
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
    
    $filename = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $filename;

    // Pindahkan file yang diunggah dari lokasi sementara ke lokasi permanen
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        
        // 2. SUKSES: Cetak respons dalam format JSON
        // Kunci 'filename' ini akan digunakan di langkah 3 JavaScript Anda
        echo json_encode([
            "success" => true,
            "message" => "Gambar berhasil disimpan.",
            "filename" => $filename // Ini yang dibutuhkan oleh simpan_deteksi.php
        ]);
    
    } else {
        
        // 3. GAGAL Pindah File: Cetak respons dalam format JSON
        echo json_encode([
            "success" => false,
            "message" => "Gagal menyimpan gambar di direktori server."
        ]);
    }

} else {
    
    // 4. GAGAL Upload (Mungkin file terlalu besar, dsb.): Cetak respons dalam format JSON
    http_response_code(400); // Mengatur status HTTP menjadi 400 Bad Request
    echo json_encode([
        "success" => false,
        "message" => "Terjadi kesalahan pada saat upload file. (Error Code: " . $_FILES["image"]["error"] . ")"
    ]);
}

// Pastikan tidak ada output lain setelah ini (seperti spasi atau karakter tak terlihat)
exit;
?>