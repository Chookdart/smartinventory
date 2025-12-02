<?php
session_start();

date_default_timezone_set("Asia/Manila");


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "smartinventory");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    // Update database
    $stmt = $conn->prepare("UPDATE users SET otp_code = ?, otp_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $otp, $expiry, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {

        // Send email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'lwisdompunzalan@gmail.com';
            $mail->Password   = 'ljxb jnau cigw imyt'; // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('lwisdompunzalan@gmail.com', 'Wisdom');
            $mail->addAddress($email);
            $mail->Subject = 'Your Password Reset OTP Code';
            $mail->Body    = "Your OTP code is: $otp\nThis code is valid for 10 minutes.";

            $mail->send();

           $_SESSION['reset_email'] = $email;
            header("Location: verify_otp.php");
            exit;


        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Smart Inventory</title>
    <link rel="stylesheet" href="css/passwords.css">
</head>

<body>

<div class="fp-wrapper">

    <div class="fp-box">
        <h2>Forgot Password</h2>
        <p>Enter your email to receive a one-time password (OTP).</p>

        <form method="POST" action="forgot_password.php">
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <button type="submit" name="send_otp">Send OTP</button>

            <a href="login.php" class="back-link">Back to Login</a>
        </form>
    </div>

</div>

</body>
</html>