<?php
// reset_password.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sejarahku';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$otp = isset($_POST['otp']) ? $_POST['otp'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';

if ($email && $otp && $new_password) {
    $email = mysqli_real_escape_string($conn, $email);
    $otp = mysqli_real_escape_string($conn, $otp);
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $query = "SELECT * FROM users WHERE email='$email' AND otp='$otp'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $update = "UPDATE users SET password='$new_password_hash', otp=NULL WHERE email='$email'";
        mysqli_query($conn, $update);
        echo "<script>alert('Password berhasil direset!');window.location='login.html';</script>";
    } else {
        echo "<script>alert('OTP salah atau email tidak cocok!');window.location='reset_password.html?email=$email';</script>";
    }
} else {
    echo "<script>alert('Semua field wajib diisi!');window.location='reset_password.html?email=$email';</script>";
}
?>
