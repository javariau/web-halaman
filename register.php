<?php
// Aktifkan error reporting untuk debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'ulangan';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn)
    die('Koneksi gagal: ' . mysqli_connect_error());

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if ($username && $email && $password) {
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $cek = mysqli_query($conn, "SELECT * FROM bintang WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = 'Email sudah terdaftar!';
        } else {
            $insert = "INSERT INTO bintang (username, email, sandi) VALUES ('$username', '$email', '$password_hash')";
            if (mysqli_query($conn, $insert)) {
                // Redirect ke main.html setelah sukses daftar
                header('Location: main.html');
                exit();
            } else {
                $error = 'Gagal mendaftar! Error: ' . mysqli_error($conn);
            }
        }
    } else {
        $error = 'Semua field harus diisi!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SejarahKu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f5f7fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: white;
            padding: 32px 28px;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(44,62,80,0.12);
            width: 100%;
            max-width: 370px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #2c3e50;
        }
        .register-container form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .register-container input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .register-container button {
            padding: 10px;
            border-radius: 8px;
            border: none;
            background: #e74c3c;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
        }
        .register-container .login-link {
            text-align: center;
            margin-top: 18px;
        }
        .register-container .login-link a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Daftar Akun Baru</h2>
        <?php if ($error): ?>
            <div style="color: #e74c3c; text-align: center; margin-bottom: 12px; font-weight:600;"> <?= $error ?> </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: #27ae60; text-align: center; margin-bottom: 12px; font-weight:600;"> <?= $success ?> </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Nama Lengkap" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            <input type="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar</button>
        </form>
        <div style="margin: 18px 0; text-align: center; color: #888;">atau daftar dengan</div>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button style="background: #DB4437; color: white; border: none; border-radius: 8px; padding: 10px; font-weight: 600; cursor: pointer;">
                <i class="fab fa-google"></i> Google
            </button>
            <button style="background: #4267B2; color: white; border: none; border-radius: 8px; padding: 10px; font-weight: 600; cursor: pointer;">
                <i class="fab fa-facebook-f"></i> Facebook
            </button>
        </div>
        <div class="login-link">
            Sudah punya akun? <a href="main.html">Login</a><br>
            <a href="halaman.html" style="color:#2c3e50;text-decoration:none;font-size:0.98rem;">Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
