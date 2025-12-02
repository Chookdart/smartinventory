<?php
session_start();
date_default_timezone_set("Asia/Manila");

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT otp_code, otp_expiry FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($db_otp, $db_expiry);
    $stmt->fetch();
    $stmt->close();

    if ($otp === $db_otp && strtotime($db_expiry) > time()) {
        $update = $conn->prepare("UPDATE users SET password = ?, otp_code = NULL, otp_expiry = NULL WHERE email = ?");
        $update->bind_param("ss", $new_password, $email);
        $update->execute();
        //echo "Password updated!";
        header("Location: test.php?email=" . urlencode($email));
            exit;
    } else {
        echo "Invalid or expired OTP.";
    }
}
?>
<!-- Form -->
<form method="post">
    <input type="email" name="email" required placeholder="Email"><br>
    <input type="text" name="otp" required placeholder="Enter OTP"><br>
    <input type="password" name="new_password" required placeholder="New Password"><br>
    <button type="submit">Reset Password</button>
</form>
