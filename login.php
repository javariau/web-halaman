<?php
// login.php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'app';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Ambil data dari form
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validasi login
if ($email && $password) {
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        // Cek password (diasumsikan sudah di-hash)
        if (password_verify($password, $row['password'])) {
            // Login sukses
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            header('Location: main.html');
            exit();
        } else {
            echo "<script>alert('Password salah!');window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!');window.location='login.html';</script>";
    }
} else {
    echo "<script>alert('Email dan password wajib diisi!');window.location='login.html';</script>";
}
?>
