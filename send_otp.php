<?php
// send_otp.php dengan PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // pastikan PHPMailer sudah diinstall via composer

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sejarahku';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
if ($email) {
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $otp = rand(100000, 999999);
        $update = "UPDATE users SET otp='$otp' WHERE email='$email'";
        mysqli_query($conn, $update);
        // Kirim OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // ganti dengan SMTP server Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // ganti dengan email Anda
            $mail->Password = 'your_email_password'; // ganti dengan password email/app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('your_email@gmail.com', 'SejarahKu');
            $mail->addAddress($email);
            $mail->Subject = 'Kode OTP Reset Password';
            $mail->Body = "Kode OTP Anda: $otp";
            $mail->send();
            echo "<script>alert('OTP sudah dikirim ke email Anda!');window.location='verify_otp.html?email=$email';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Gagal mengirim email: {$mail->ErrorInfo}');window.location='forgot.html';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!');window.location='forgot.html';</script>";
    }
} else {
    echo "<script>alert('Email wajib diisi!');window.location='forgot.html';</script>";
}
?>
