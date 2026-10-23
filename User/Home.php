<?php
session_start();
if ($_SESSION['level'] != 'User') {
    header("location: ../Login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Home - Deteksi Daun Stroberi</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>

    /* === DASAR & BACKGROUND AESTHETIC === */
    html, body { height: 100%; margin: 0; }
    body { 
      background-color: #fff5f5;
      background-image: 
        radial-gradient(#d32f2f1a 1px, transparent 1px), 
        radial-gradient(#388e3c1a 1px, transparent 1px),
        linear-gradient(135deg, #fff5f5 0%, #f0fdf4 100%);
      background-size: 40px 40px, 40px 40px, 100% 100%;
      background-position: 0 0, 20px 20px, 0 0;
      font-family: "Poppins", sans-serif;
      display: flex;
      flex-direction: column;
      color: #333;
    }
    .content-wrapper { flex: 1 0 auto; }

    /* === NAVBAR (Mentok Kanan) === */
    .navbar { background: linear-gradient(90deg, #d32f2f, #388e3c); padding: 15px 0; }
    .navbar-collapse { justify-content: flex-end; }
    .navbar .nav-item { margin-left: 35px; }
    .navbar .nav-link {
      position: relative; color: #ffffff !important; font-weight: 600;
      display: flex; align-items: center; gap: 8px; padding: 10px 5px;
      transition: transform 0.5s ease, color 0.5s ease;
    }
    .navbar .nav-link:hover { color: #fff700 !important; transform: translateY(-5px); }
    .navbar .nav-link::after {
      content: ""; position: absolute; left: 0; bottom: -2px; width: 0; height: 3.5px;
      background: #fff700; border-radius: 10px; transition: width 0.5s ease; 
    }
    .navbar .nav-link:hover::after { width: 100%; }

    /* === HERO SECTION === */
    .hero-section { padding: 80px 0; animation: fadeInDown 1.5s ease-out; }
    .hero-title {
      font-weight: 800; font-size: 3.5rem;
      background: -webkit-linear-gradient(#d32f2f, #388e3c);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    /* === TOMBOL DETEKSI (HOVER HIJAU) === */
    .btn-mulai-deteksi {
      background: linear-gradient(45deg, #d32f2f, #ff5252);
      color: white; 
      border-radius: 50px; 
      padding: 18px 45px;
      font-weight: 700; 
      border: none; 
      transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
      display: inline-block; 
      text-decoration: none;
      box-shadow: 0 10px 20px rgba(211, 47, 47, 0.2);
    }
    .btn-mulai-deteksi:hover { 
      background: #388e3c !important; /* Berubah Hijau saat kursor sentuh */
      color: #ffffff !important; 
      transform: translateY(-8px); 
      box-shadow: 0 15px 30px rgba(56, 142, 60, 0.4);
    }

    /* === FEATURE CARDS AESTHETIC === */
    .feature-card {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.5);
      border-radius: 30px; padding: 40px; text-align: center;
      height: 100%; transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .feature-card:hover {
      border: 1px solid rgba(255, 0, 0, 0.5);
      transform: translateY(-20px);
      box-shadow: 0 20px 40px rgba(56, 142, 60, 0.15);
    }
    .feature-icon { font-size: 3.5rem; margin-bottom: 20px; transition: transform 0.6s; }
    .feature-card:hover .feature-icon { transform: scale(1.2); }

    /* === CNN EXPLANATION BOX === */
    .cnn-info-box {
      background: white;
      border-radius: 40px;
      padding: 50px;
      border: 1px solid rgba(0,0,0,0.05);
      box-shadow: 0 20px 40px rgba(0,0,0,0.02);
    }

    /* === PROCESS STEP === */
    .process-step {
      background: #ffffff; border-radius: 20px; padding: 25px;
      margin-bottom: 15px; border-left: 5px solid #d32f2f;
      transition: all 0.3s ease;
    }
    .process-step:hover {
      border-left-color: #388e3c;
      transform: translateX(10px);
    }

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

    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>

<body>
<div class="content-wrapper">
  <nav class="navbar navbar-expand-lg shadow-sm sticky-top">
    <div class="container-fluid px-5">
      <a class="navbar-brand fw-bold text-white" href="home.php">🍓 STRAWBERRY CARE </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="home.php"><i class="fas fa-home"></i> Home</a></li>
          <li class="nav-item"><a class="nav-link" href="profil.php"><i class="fas fa-user"></i> Riwayat</a></li>
          <li class="nav-item"><a class="nav-link" href="Penyakit.php"><i class="fas fa-leaf"></i> Penyakit</a></li>
          <li class="nav-item"><a class="nav-link" href="../templates/Deteksi.html"><i class="fas fa-search"></i> Deteksi</a></li>
          <li class="nav-item"><a class="nav-link" href="../Logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="hero-section">
    <div class="container px-5">
      <div class="row gx-5 align-items-center">
        <div class="col-lg-6">
            <h6 class="text-danger fw-bold text-uppercase ls-2">Intelligence Agriculture</h6>
            <h1 class="hero-title">Halo, <?= $_SESSION['username']; ?>!</h1>
            <p class="lead text-muted mb-4">Lindungi kualitas panen Anda dengan deteksi penyakit berbasis AI yang dirancang untuk presisi maksimal.</p>
            
            <a class="btn-mulai-deteksi shadow" href="../templates/Deteksi.html">
                <i class="fas fa-camera-retro me-2"></i> Mulai Deteksi Sekarang
            </a>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <img class="img-fluid rounded-5 shadow-lg" src="../assets/img/Banner.jpg" alt="Banner" style="border: 8px solid white;"/>
        </div>
      </div>
    </div>
  </header>

  <section class="container px-5 my-5">
    <div class="row g-4 text-center">
      <div class="col-lg-4">
        <div class="feature-card shadow-sm">
          <div class="feature-icon" style="color: #d32f2f;"><i class="fas fa-microscope"></i></div>
          <h4 class="fw-bold">Analisis Akurat</h4>
          <p class="text-muted small">Mengidentifikasi gejala penyakit terkecil melalui ekstraksi fitur daun secara digital.</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="feature-card shadow-sm">
          <div class="feature-icon" style="color: #388e3c;"><i class="fas fa-tachometer-alt"></i></div>
          <h4 class="fw-bold">Respon Cepat</h4>
          <p class="text-muted small">Algoritma kami memberikan hasil diagnosa instan sesaat setelah foto diunggah.</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="feature-card shadow-sm">
          <div class="feature-icon" style="color: #d32f2f;"><i class="fas fa-lightbulb"></i></div>
          <h4 class="fw-bold">Solusi Terpadu</h4>
          <p class="text-muted small">Menyediakan langkah penanganan yang tepat sasaran berdasarkan jenis penyakit.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="container px-5 my-5">
    <div class="cnn-info-box shadow-sm">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h2 class="fw-bold mb-3" style="color: #388e3c;">Teknologi Deep Learning (CNN)</h2>
          <p class="text-muted" style="text-align: justify;">
            Sistem ini ditenagai oleh <b>Convolutional Neural Network (CNN)</b>, sebuah arsitektur cerdas yang meniru cara kerja otak manusia dalam mengenali objek visual. CNN memproses tekstur daun melalui lapisan konvolusi untuk membedakan antara tanaman sehat dan tanaman yang terkena infeksi seperti <i>Leaf Spot</i> atau <i>Scorch</i> dengan tingkat akurasi tinggi.
          </p>
        </div>
        <div class="col-lg-5 text-center">
            <div class="p-4 rounded-4" style="background: #f0fdf4; border: 2px solid #388e3c22;">
                <i class="fas fa-brain fa-4x text-success mb-3"></i>
                <h5 class="fw-bold mb-0">AI Engine Active</h5>
                <p class="small text-muted mb-0">Convolutional Neural Network (CNN)</p>
            </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container px-5 mb-5">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5">
        <h2 class="fw-bold text-danger">Cara Kerja Sistem</h2>
        <p class="text-muted">Proses diagnosa hanya memerlukan hitungan detik.</p>
        <img src="../assets/img/Banner.jpg" class="img-fluid rounded-4 shadow-sm" alt="Workflow">
      </div>
      <div class="col-lg-7">
        <div class="process-step shadow-sm">
          <h6 class="fw-bold text-danger">1. Pengambilan Gambar</h6>
          <p class="small text-muted mb-0">Gunakan kamera smartphone untuk memotret daun yang bergejala.</p>
        </div>
        <div class="process-step shadow-sm">
          <h6 class="fw-bold text-danger">2. Ekstraksi Fitur</h6>
          <p class="small text-muted mb-0">AI membedah pola warna dan bercak pada permukaan citra daun.</p>
        </div>
        <div class="process-step shadow-sm">
          <h6 class="fw-bold text-danger">3. Klasifikasi CNN</h6>
          <p class="small text-muted mb-0">Model cerdas menentukan jenis patogen atau jamur yang menyerang.</p>
        </div>
        <div class="process-step shadow-sm">
          <h6 class="fw-bold text-danger">4. Diagnosis Akhir</h6>
          <p class="small text-muted mb-0">Hasil klasifikasi muncul beserta rekomendasi tindakan medis.</p>
        </div>
      </div>
    </div>
  </section>
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