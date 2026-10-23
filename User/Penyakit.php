<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ensiklopedia Penyakit - Daun Stroberi</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    /* === DASAR & BACKGROUND === */
    html, body { height: 100%; margin: 0; }
    body { 
      background: linear-gradient(135deg, #fff5f5 0%, #f0fdf4 100%); 
      font-family: "Poppins", sans-serif;
      display: flex;
      flex-direction: column;
      color: #333;
    }
    .content-wrapper { flex: 1 0 auto; }

    /* === NAVBAR === */
    .navbar { background: linear-gradient(90deg, #d32f2f, #388e3c); padding: 15px 0; }
    .navbar-collapse { display: flex !important; justify-content: flex-end; }
    .navbar .nav-item { margin-left: 35px; }
    .navbar .nav-link {
      position: relative; color: #ffffff !important; font-weight: 600;
      display: flex; align-items: center; gap: 8px; padding: 10px 5px;
      transition: transform 1.8s cubic-bezier(0.22, 1, 0.36, 1), color 1.5s ease;
    }
    .navbar .nav-link:hover { color: #fff700 !important; transform: translateY(-12px); }
    .navbar .nav-link::after {
      content: ""; position: absolute; left: 0; bottom: -2px; width: 0; height: 3.5px;
      background: #fff700; border-radius: 10px; transition: width 1.5s cubic-bezier(0.22, 1, 0.36, 1); 
    }
    .navbar .nav-link:hover::after { width: 100%; }
    .navbar .nav-link.active::after { width: 100%; background: #ffe082; }

    /* === HEADER === */
    .header-modern {
      padding: 80px 0 40px;
      text-align: center;
      animation: fadeInDown 2s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .header-modern h2 {
      font-weight: 700; font-size: 3rem;
      background: -webkit-linear-gradient(#d32f2f, #388e3c);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      margin-bottom: 15px;
    }

    /* === DISEASE CARD === */
    .card-disease {
      border: none; border-radius: 30px;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 15px 35px rgba(0,0,0,0.05);
      transition: all 1.5s cubic-bezier(0.22, 1, 0.36, 1);
      overflow: hidden; height: 100%; cursor: pointer;
    }
    .card-disease:hover {
      border: 1px solid rgba(234, 18, 18, 0.5);
      transform: translateY(-20px) scale(1.02);
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 50px 75px rgba(211, 47, 47, 0.1);
    }
    .img-container { overflow: hidden; }
    .card-disease img {
      height: 280px; width: 100%; object-fit: cover;
      transition: transform 2s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .card-disease:hover img { transform: scale(1.15); }
    .card-body-custom { padding: 30px; text-align: center; }
    .card-title-custom { font-weight: 700; color: #d32f2f; font-size: 1.4rem; }
    .card-healthy .card-title-custom { color: #2e7d32; }

    /* === INFO SECTION (HOVER EFFECTS) === */
    .info-aesthetic {
      background: #ffffff; border-radius: 30px; padding: 50px; margin-top: 50px;
      border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 20px 40px rgba(0,0,0,0.02);
      animation: fadeInUp 1.8s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .info-aesthetic h3 { font-weight: 700; color: #388e3c; margin-bottom: 25px; display: flex; align-items: center; gap: 15px; }
    
    .prevention-card {
      background: #f9f9f9; border-radius: 20px; padding: 25px; height: 100%;
      transition: all 0.4s ease; border: 2px solid transparent;
    }
    .prevention-card:hover { transform: translateY(-10px); color: white; }
    .prevention-card:hover h6 { color: white !important; }
    .prevention-card:hover p { color: rgba(255,255,255,0.9) !important; }
    
    .card-bibit:hover { background: #d32f2f; border-color: #b71c1c; }
    .card-jarak:hover { background: #388e3c; border-color: #2e7d32; }
    .card-lembab:hover { background: #0288d1; border-color: #01579b; }
    .card-monitor:hover { background: #fbc02d; border-color: #f9a825; }

    /* === CTA CARD & BUTTON === */
    .cta-aesthetic {
      background: linear-gradient(135deg, #d32f2f 0%, #f44336 100%);
      border-radius: 35px; padding: 60px 40px; color: white; text-align: center;
      margin: 80px 0; position: relative; overflow: hidden;
    }
    .btn-white-aesthetic {
      background: #ffffff; color: #d32f2f; padding: 15px 45px; border-radius: 50px;
      font-weight: 700; text-decoration: none; display: inline-block;
      transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    /* Efek Hover Hijau */
    .btn-white-aesthetic:hover { 
      transform: translateY(-5px); 
      background: #388e3c !important; 
      color: #ffffff !important; 
      box-shadow: 0 15px 30px rgba(56, 142, 60, 0.4);
    }
    /* Efek Klik Aktif */
    .btn-white-aesthetic:active { background: #2e7d32 !important; transform: scale(0.95); }

    /* === MODAL STYLING === */
    .modal-content { border: none; border-radius: 35px; overflow: hidden; }
    .modal-header { border-bottom: none; padding: 25px 30px 10px; }
    .modal-body { padding: 0 30px 35px; }
    .modal-img-premium { 
        width: 100%; border-radius: 20px; margin-bottom: 20px; 
        object-fit: cover; height: 300px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .modal-desc-box { background: #f8f9fa; padding: 20px; border-radius: 20px; border-left: 5px solid #d32f2f; }
    .modal-desc-healthy { border-left-color: #2e7d32; }

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-40px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

    /* === FOOTER SLIM MINIMALIS === */
    footer {
      background: linear-gradient(90deg, #d32f2f, #388e3c);
      color: white;
      padding: 20px 0; /* Padding diperkecil agar box tidak besar */
      margin-top: 50px;
      
      width: 100%;
    }

    .footer-text-main {
      font-size: 0.95rem;
      font-weight: 600;
      margin-bottom: 2px;
    }

    .footer-text-sub {
      font-size: 0.75rem;
      opacity: 0.8;
      letter-spacing: 0.5px;
    }
  </style>
</head>
<body>

<div class="content-wrapper">
    <nav class="navbar navbar-expand-lg shadow-sm">
      <div class="container-fluid px-5">
        <a class="navbar-brand fw-bold text-white" href="Home.php">🍓 STRAWBERRY CARE</a>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link fw-semibold" href="Home.php"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="profil.php"><i class="fas fa-user"></i>Riwayat</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold active" href="Penyakit.php"><i class="fas fa-leaf"></i> Penyakit</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="../templates/Deteksi.html"><i class="fas fa-search"></i> Deteksi</a></li>
            <li class="nav-item"><a class="nav-link fw-semibold" href="../Logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <header class="header-modern">
        <h2>Gallery of Conditions</h2>
        <p class="text-muted">Kenali perbedaan antara daun stroberi yang sehat dan yang terinfeksi penyakit secara akurat.</p>
      </header>

      <div class="row g-5">
        <div class="col-md-4">
          <div class="card-disease" data-bs-toggle="modal" data-bs-target="#leafSpotModal">
            <div class="img-container"><img src="../assets/IMG/leaf spot.jpg" alt="Leaf Spot"></div>
            <div class="card-body-custom"><h5 class="card-title-custom">Leaf Spot</h5><p class="text-muted small">Mycosphaerella fragariae</p></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-disease" data-bs-toggle="modal" data-bs-target="#leafScorchModal">
            <div class="img-container"><img src="../assets/IMG/leaf scorch.jpg" alt="Leaf Scorch"></div>
            <div class="card-body-custom"><h5 class="card-title-custom">Leaf Scorch</h5><p class="text-muted small">Diplocarpon earlianum</p></div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-disease card-healthy" data-bs-toggle="modal" data-bs-target="#healthyModal">
            <div class="img-container"><img src="../assets/IMG/healty.jpg" alt="Healthy Leaf"></div>
            <div class="card-body-custom"><h5 class="card-title-custom">Healthy Leaf</h5><p class="text-muted small">Daun Sehat & Segar</p></div>
          </div>
        </div>
      </div>

      <div class="info-aesthetic">
        <h3><i class="fas fa-shield-alt"></i> Tips Pencegahan & Penanganan</h3>
        <p class="text-muted mb-4">Arahkan kursor pada kartu untuk melihat detail fokus penanganan:</p>
        <div class="row g-4 text-start">
          <div class="col-md-6">
            <div class="prevention-card card-bibit">
              <h6 class="fw-bold text-danger"><i class="fas fa-certificate me-2"></i> Bibit Sehat</h6>
              <p class="small text-muted mb-0">Pastikan bibit berasal dari indukan bersertifikat dan bebas dari spora jamur bawaan atau virus.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="prevention-card card-jarak">
              <h6 class="fw-bold text-success"><i class="fas fa-wind me-2"></i> Jarak Tanam</h6>
              <p class="small text-muted mb-0">Atur jarak antar tanaman minimal 30cm untuk menjamin sirkulasi udara optimal dan akses cahaya matahari.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="prevention-card card-lembab">
              <h6 class="fw-bold text-primary"><i class="fas fa-tint-slash me-2"></i> Manajemen Kelembapan</h6>
              <p class="small text-muted mb-0">Gunakan sistem irigasi tetes untuk menghindari percikan air langsung pada permukaan daun stroberi.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="prevention-card card-monitor">
              <h6 class="fw-bold text-warning"><i class="fas fa-eye me-2"></i> Monitoring Berkala</h6>
              <p class="small text-muted mb-0">Lakukan pemangkasan daun tua secara rutin dan pantau gejala bercak setiap pagi hari.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="cta-aesthetic">
        <h3 class="fw-bold mb-3">Siap Memeriksa Tanaman Anda?</h3>
        <p class="mb-4 opacity-75">Gunakan teknologi Vision AI kami untuk diagnosis instan dan akurat.</p>
        <a href="../templates/Deteksi.html" class="btn-white-aesthetic"><i class="fas fa-microscope me-2"></i> Ayo Deteksi Sekarang</a>
      </div>
    </div>
</div>


<div class="modal fade" id="leafSpotModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold text-danger">Detail Penyakit: Leaf Spot</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <img src="../assets/IMG/leaf spot.jpg" class="modal-img-premium" alt="Leaf Spot">
        <div class="modal-desc-box">
          <h6 class="fw-bold">Deskripsi & Gejala:</h6>
          <p class="small mb-3 text-muted">Disebabkan oleh jamur <strong>Mycosphaerella fragariae</strong>. Gejala bintik ungu melingkar dengan bagian tengah berwarna putih keabu-abuan.</p>
          <h6 class="fw-bold">Penanganan Strategis:</h6>
          <ul class="small text-muted">
            <li>Buang dan musnahkan daun yang terinfeksi.</li>
            <li>Gunakan fungisida tembaga untuk menghentikan penyebaran spora.</li>
            <li>Pastikan sirkulasi udara di sekitar tanaman tetap terjaga.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="leafScorchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold text-danger">Detail Penyakit: Leaf Scorch</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <img src="../assets/IMG/leaf scorch.jpg" class="modal-img-premium" alt="Leaf Scorch">
        <div class="modal-desc-box">
          <h6 class="fw-bold">Deskripsi & Gejala:</h6>
          <p class="small mb-3 text-muted">Disebabkan oleh jamur <strong>Diplocarpon earlianum</strong>. Bercak ungu gelap tak beraturan yang membuat daun tampak seperti terbakar atau hangus.</p>
          <h6 class="fw-bold">Penanganan Strategis:</h6>
          <ul class="small text-muted">
            <li>Perbaiki drainase tanah agar tidak terlalu lembap.</li>
            <li>Gunakan varietas tanaman stroberi yang memiliki ketahanan terhadap bercak.</li>
            <li>Lakukan penyiraman hanya pada bagian pangkal tanaman (tanah).</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="healthyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold text-success">Kondisi: Daun Sehat</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <img src="../assets/IMG/healty.jpg" class="modal-img-premium" alt="Healthy Leaf">
        <div class="modal-desc-box modal-desc-healthy">
          <h6 class="fw-bold">Karakteristik Daun Sehat:</h6>
          <p class="small mb-3 text-muted">Warna hijau segar merata, tekstur kokoh, permukaan bersih tanpa bercak abnormal, dan pertumbuhan tajuk yang simetris.</p>
          <h6 class="fw-bold">Tips Mempertahankan:</h6>
          <ul class="small text-muted">
            <li>Pantau nutrisi tanaman dan pH media tanam secara rutin.</li>
            <li>Gunakan mulsa untuk menjaga kebersihan daun dari cipratan tanah.</li>
            <li>Jaga kebersihan area kebun dari gulma yang bisa menjadi inang penyakit.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container text-center">
    <div class="footer-text-main">
      🍓 AI Agriculture System | © 2025 Muhammad Doni Saputra & Era Dani Kurniawan
    </div>
    
    <div class="footer-text-sub">
      Deep Learning (CNN) Strawberry Disease Detection
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>