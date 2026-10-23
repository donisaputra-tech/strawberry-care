<?php
session_start();
include "koneksi.php";

$login_error = '';
$register_error = '';

// Logika Login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = $data['level'];
        header("location: " . ($data['level'] == "Admin" ? "admin/home.php" : "User/home.php"));
        exit;
    } else { $login_error = "Username atau password salah!"; }
}

// Logika Register
if (isset($_POST['daftar'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['reg_username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['reg_password']);
    $konfirmasi = mysqli_real_escape_string($koneksi, $_POST['reg_konfirmasi']);
    if ($password !== $konfirmasi) { $register_error = "Konfirmasi tidak cocok!"; }
    else {
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) { $register_error = "Username sudah ada!"; }
        else {
            $simpan = mysqli_query($koneksi, "INSERT INTO users (username, password, level) VALUES ('$username', '$password', 'User')");
            if ($simpan) { echo "<script>alert('Berhasil! Silakan Login');</script>"; }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strawberry AI — Login & Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #d32f2f;
            --primary-green: #388e3c;
        }

        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: hidden;
            background: #000;
        }

        /* Background TETAP TAJAM (Tanpa Blur) */
        .bg-fixed {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url('./assets/IMG/BG2.jpg') no-repeat center center/cover;
            z-index: -2;
        }

        /* Overlay gelap tipis agar teks terbaca, tapi tetap tajam */
        .overlay-main {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }

        /* Container Utama */
        .container {
            background: rgba(255, 255, 255, 0.1); /* Transparansi */
            backdrop-filter: blur(10px); /* Efek kaca hanya di dalam kotak */
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.5);
            position: relative;
            width: 800px;
            max-width: 100%;
            min-height: 500px;
            overflow: hidden;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

        .container.right-panel-active .sign-in-container { transform: translateX(100%); opacity: 0; }
        .container.right-panel-active .sign-up-container { transform: translateX(100%); opacity: 1; z-index: 5; }

        form {
            padding: 0 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h1 { color: #fff; margin-bottom: 10px; font-weight: 700; }
        p { color: #eee; font-size: 13px; margin-bottom: 20px; }

        .input-group { width: 100%; margin-bottom: 12px; position: relative; }

        input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            color: #fff;
            outline: none;
        }

        input::placeholder { color: #ddd; }

        .input-group i {
            position: absolute;
            left: 15px; top: 50%;
            transform: translateY(-50%);
            color: #fff;
        }

        .btn-submit {
            background: var(--primary-red);
            color: #fff;
            border-radius: 50px;
            border: none;
            padding: 10px 40px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-green);
            transform: scale(1.05);
        }

        /* Overlay Samping (Merah ke Hijau) */
        .overlay-container {
            position: absolute;
            top: 0; left: 50%;
            width: 50%; height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container { transform: translateX(-100%); }

        .overlay {
            background: linear-gradient(135deg, rgba(211, 47, 47, 0.9), rgba(56, 142, 60, 0.9));
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay { transform: translateX(50%); }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0; height: 100%; width: 50%;
            transition: transform 0.6s ease-in-out;
        }

        .overlay-right { right: 0; }
        
        .ghost-btn {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 50px;
            padding: 8px 25px;
            cursor: pointer;
            font-weight: 600;
        }
        .ghost-btn:hover { background: #fff; color: var(--primary-green); }

        .alert { color: #ffeb3b; font-size: 12px; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="bg-fixed"></div>
<div class="overlay-main"></div>

<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form method="POST">
            <h1>Daftar</h1>
            <p>Buat akun baru</p>
            <?php if($register_error) echo "<div class='alert'>$register_error</div>"; ?>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="reg_username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="reg_password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <i class="fas fa-shield-alt"></i>
                <input type="password" name="reg_konfirmasi" placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" name="daftar" class="btn-submit">Daftar</button>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form method="POST">
            <h1>Masuk</h1>
            <p>Selamat datang kembali!</p>
            <?php if($login_error) echo "<div class='alert'>$login_error</div>"; ?>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn-submit">Masuk</button>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Hello, Friend!</h1>
                <p>Sudah punya akun? Masuk sekarang.</p>
                <button class="ghost-btn" id="signIn">Ke Halaman Login</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Guest!</h1>
                <p>Belum punya akun? Daftar dulu yuk.</p>
                <button class="ghost-btn" id="signUp">Ke Halaman Daftar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => container.classList.add("right-panel-active"));
    signInButton.addEventListener('click', () => container.classList.remove("right-panel-active"));
</script>

</body>
</html>