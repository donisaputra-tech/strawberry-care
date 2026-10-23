<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'User' || !isset($_SESSION['id_user'])) {
    header("location: ../Login.php");
    exit;
}
include "../Koneksi.php";
$id_user = $_SESSION['id_user'];

// Query diperbarui untuk mengambil id_riwayat agar bisa dihapus
$sql = "SELECT id_riwayat, gambar, hasil, probability, deskripsi, penanganan, tanggal 
        FROM riwayat_deteksi 
        WHERE id_user = ?
        ORDER BY id_riwayat DESC";

$stmt = mysqli_prepare($koneksi, $sql);
$query = false;

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    if (mysqli_stmt_execute($stmt)) {
        $query = mysqli_stmt_get_result($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Deteksi - Profil</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <style>
    html, body { height: 100%; margin: 0; }
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(135deg, #fce4ec, #e8f5e9);
      display: flex; flex-direction: column;
    }
    .content-wrapper { flex: 1 0 auto; }

    /* Navbar styling tetap sama */
    .navbar { background: linear-gradient(90deg, #d32f2f, #388e3c); padding: 15px 0; }
    .navbar-collapse { display: flex !important; justify-content: flex-end; }
    .navbar .nav-item { margin-left: 35px; }
    .navbar .nav-link {
      position: relative; color: #ffffff !important; font-weight: 600;
      transition: transform 0.5s ease, color 0.5s ease;
    }
    .navbar .nav-link:hover { color: #fff700 !important; transform: translateY(-5px); }

    /* Card styling */
    .card-riwayat {
      border: 2px solid #d32f2f; border-radius: 15px; background: #fff;
      transition: all 0.5s ease; cursor: pointer; position: relative;
    }
    .card-riwayat:hover { transform: scale(1.02); border-color: #388e3c; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    
    .hasil-badge {
      background: #d32f2f; color: white; font-weight: 600;
      border-radius: 8px; padding: 2px 10px; display: inline-block;
    }

    .btn-delete {
        position: absolute; top: 15px; right: 15px;
        color: #dc3545; background: rgba(220, 53, 69, 0.1);
        border-radius: 50%; width: 35px; height: 35px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease; z-index: 10;
    }
    .btn-delete:hover { background: #dc3545; color: white; transform: rotate(90deg); }

    /* Popup styling */
    .popup {
      position: fixed; inset: 0; display: none;
      align-items: center; justify-content: center;
      z-index: 9999; background: rgba(0,0,0,0.5); 
    }
    .popup.active { display: flex; }
    .popup-content {
      background: #fff; border-radius: 20px;
      max-width: 800px; width: 90%; padding: 30px; position: relative;
      animation: popIn 0.4s cubic-bezier(0.17, 0.89, 0.32, 1.27);
    }
    @keyframes popIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .close-btn { position: absolute; top: 15px; right: 20px; font-size: 2rem; cursor: pointer; color: #d32f2f; }

    footer { background: linear-gradient(90deg, #d32f2f, #388e3c); color: white; padding: 20px 0; margin-top: 50px; }
  </style>
</head>
<body>

<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg shadow-sm">
      <div class="container-fluid px-5">
        <a class="navbar-brand fw-bold text-white" href="home.php">🍓 STRAWBERRY CARE</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link fw-semibold" href="home.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold active" href="profil.php"><i class="fas fa-user"></i>Riwayat</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="Penyakit.php"><i class="fas fa-leaf"></i> Penyakit</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="../templates/Deteksi.html"><i class="fas fa-search"></i> Deteksi</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="../Logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container py-5">
      <h3 class="text-center fw-bold mb-5 text-danger"><i class="fas fa-history"></i> Riwayat Deteksi Anda</h3>

      <?php if (!$query || mysqli_num_rows($query) == 0) { ?>
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
            <p class="text-muted">Belum ada riwayat deteksi. Silakan lakukan deteksi terlebih dahulu.</p>
        </div>
      <?php } else { ?>
        <div class="row g-4">
          <?php $i=1; while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="col-md-6">
              <div class="card card-riwayat p-3">
                <div class="btn-delete" onclick="konfirmasiHapus(<?= $row['id_riwayat'] ?>)" title="Hapus Riwayat">
                    <i class="fas fa-trash-alt"></i>
                </div>

                <div class="d-flex align-items-center" onclick="openPopup(<?= $i ?>)">
                  <img src="../uploads/<?= htmlspecialchars($row['gambar']); ?>" width="85" height="85" class="rounded me-3" style="object-fit: cover; border: 2px solid #eee;">
                  <div>
                    <div class="hasil-badge mb-1"><?= htmlspecialchars($row['hasil']); ?></div>
                    <div class="fw-bold text-success" style="font-size: 0.9rem;"><?= number_format($row['probability'] * 100, 2); ?>% Match</div>
                    <small class="text-muted d-block"><i class="far fa-clock"></i> <?= date('d M Y, H:i', strtotime($row['tanggal'])); ?></small>
                  </div>
                </div>
              </div>
            </div>

            <div class="popup" id="popup<?= $i ?>">
              <div class="popup-content">
                <span class="close-btn" onclick="closePopup(<?= $i ?>)">&times;</span>
                <div class="row g-4 align-items-center"> 
                  <div class="col-md-5 text-center">
                    <img src="../uploads/<?= htmlspecialchars($row['gambar']); ?>" class="img-fluid rounded shadow-sm border" style="max-height: 300px;">
                  </div>
                  <div class="col-md-7">
                    <h5 class="fw-bold text-danger mb-3"><i class="fas fa-microscope"></i> Detail Analisis</h5>
                    <p class="mb-1"><strong>Kondisi:</strong> <?= htmlspecialchars($row['hasil']); ?></p>
                    <p class="mb-3"><strong>Akurasi AI:</strong> <span class="badge bg-success"><?= number_format($row['probability'] * 100, 2); ?>%</span></p>
                    <hr>
                    <p class="mb-1"><strong>Deskripsi:</strong></p>
                    <p class="text-muted small"><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                    <p class="mb-1"><strong>Langkah Penanganan:</strong></p>
                    <ul class="list-unstyled ps-2 small">
                      <?php
                        $lines = preg_split("/[\r\n,]+/", $row['penanganan']);
                        foreach ($lines as $line) {
                          if (trim($line) !== "") echo "<li class='mb-1'><i class='fas fa-check-circle text-success me-2'></i>" . htmlspecialchars(trim($line)) . "</li>";
                        }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          <?php $i++; } ?>
        </div>
      <?php } ?>
    </div>
</div>

<footer>
  <div class="container text-center">
    <div class="footer-text-main">🍓 AI Agriculture System | © 2025</div>
  </div>
</footer>

<script>
  function openPopup(id) { document.getElementById('popup' + id).classList.add('active'); }
  function closePopup(id) { document.getElementById('popup' + id).classList.remove('active'); }
  
  // Fungsi Hapus dengan SweetAlert2
  function konfirmasiHapus(id) {
      Swal.fire({
          title: 'Hapus Riwayat?',
          text: "Data deteksi dan gambar akan dihapus permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = "hapus_riwayat.php?id=" + id;
          }
      })
  }

  // Klik di luar popup untuk menutup
  window.onclick = function(e) { if (e.target.classList.contains('popup')) { e.target.classList.remove('active'); } }
</script>

<?php if(isset($_GET['status'])): ?>
<script>
    const status = "<?= $_GET['status'] ?>";
    if(status === 'deleted') {
        Swal.fire('Terhapus!', 'Riwayat berhasil dihapus.', 'success');
    } else if(status === 'error') {
        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
    }
</script>
<?php endif; ?>

</body>
</html>