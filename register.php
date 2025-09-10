<?php
// register.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sejarahku';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username && $email && $password) {
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Email sudah terdaftar!');window.location='register.html';</script>";
    } else {
        $insert = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hash')";
        if (mysqli_query($conn, $insert)) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.');window.location='login.html';</script>";
        } else {
            echo "<script>alert('Gagal mendaftar!');window.location='register.html';</script>";
        }
    }
} else {
    echo "<script>alert('Semua field wajib diisi!');window.location='register.html';</script>";
}
?>
