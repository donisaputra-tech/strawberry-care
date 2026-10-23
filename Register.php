<?php
include "koneksi.php";

if (isset($_POST['daftar'])) {
    // Menggunakan mysqli_real_escape_string untuk keamanan tambahan
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password   = mysqli_real_escape_string($koneksi, $_POST['password']);
    $konfirmasi = mysqli_real_escape_string($koneksi, $_POST['konfirmasi']);

    // Validasi konfirmasi password
    if ($password !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah digunakan
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah dipakai!";
        } else {
            // Simpan akun baru dengan level default 'User'
            $simpan = mysqli_query($koneksi,
                "INSERT INTO users (username, password, level)
                 VALUES ('$username', '$password', 'User')");

            if ($simpan) {
                header("Location: login.php?msg=success");
                exit;
            } else {
                $error = "Gagal membuat akun!";
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun — Strawberry AI</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-red: #d32f2f;
            --primary-green: #388e3c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            background-color: #333;
        }

        /* Background & Overlay (Identik dengan Login) */
        .bg-container {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -2;
        }

        .bg-image {
            width: 100%; height: 100%;
            background-image: url('../assets/IMG/BG1.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            animation: slowZoom 20s infinite alternate;
        }

        .bg-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(211, 47, 47, 0.4), rgba(56, 142, 60, 0.4));
            backdrop-filter: blur(3px);
            z-index: -1;
        }

        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }

        /* Register Card */
        .register-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-box {
            width: 60px; height: 60px;
            background: white;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .icon-box i {
            font-size: 1.8rem;
            background: linear-gradient(var(--primary-red), var(--primary-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 { font-weight: 700; color: #222; margin-bottom: 5px; font-size: 1.4rem; }
        .subtitle { font-size: 0.7rem; color: #555; margin-bottom: 25px; letter-spacing: 1px; text-transform: uppercase; }

        .form-group { margin-bottom: 15px; text-align: left; }
        label { font-size: 0.75rem; font-weight: 600; color: #444; margin-bottom: 5px; display: block; margin-left: 5px; }
        
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; font-size: 0.9rem; }
        
        input {
            width: 100%;
            padding: 11px 15px 11px 42px;
            border: 1px solid #ddd;
            background: rgba(255,255,255,0.7);
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-green);
            background: white;
            box-shadow: 0 0 10px rgba(56, 142, 60, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(45deg, var(--primary-red), #ff5252);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.4s;
            box-shadow: 0 8px 20px rgba(211, 47, 47, 0.3);
            text-transform: uppercase;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(56, 142, 60, 0.3);
        }

        .alert-error {
            background: #ffebee; color: #c62828;
            padding: 10px; border-radius: 10px; font-size: 0.75rem;
            margin-bottom: 15px; border-left: 5px solid var(--primary-red);
            display: flex; align-items: center; gap: 8px;
            text-align: left;
        }

        .link-footer { margin-top: 20px; font-size: 0.8rem; color: #666; }
        .link-footer a { color: var(--primary-red); font-weight: 700; text-decoration: none; }
        .link-footer a:hover { color: var(--primary-green); text-decoration: underline; }
    </style>
</head>
<body>

<div class="bg-container">
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
</div>

<div class="register-card">
    <div class="icon-box">
        <i class="fas fa-user-plus"></i>
    </div>
    
    <h2>Daftar Akun</h2>
    <p class="subtitle">Bergabung dengan Strawberry AI</p>

    <?php if(isset($error)): ?>
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <div class="input-wrapper">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Buat username unik" required>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Buat password" required>
            </div>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <div class="input-wrapper">
                <i class="fas fa-check-double"></i>
                <input type="password" name="konfirmasi" placeholder="Ulangi password" required>
            </div>
        </div>

        <button type="submit" name="daftar" class="btn-submit">
            Buat Akun <i class="fas fa-rocket ms-2"></i>
        </button>
    </form>

    <div class="link-footer">
        Sudah memiliki akun? <a href="login.php">Login Sekarang</a>
    </div>
</div>

</body>
</html>