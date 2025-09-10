<?php
// login.php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'ulangan';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

session_start();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username && $password) {
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM bintang WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['sandi'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['username'];
            header('Location: halaman.html?nama=' . urlencode($row['username']));
            exit();
        } else {
            header('Location: main.html?error=Password+salah');
            exit();
        }
    } else {
        header('Location: main.html?error=Username+tidak+ditemukan');
        exit();
    }
} else {
    header('Location: main.html?error=Username+dan+password+wajib+diisi');
    exit();
}
?>
