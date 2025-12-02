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
        header("Location: login.php?email=" . urlencode($email));
            exit;
    } else {
        echo "Invalid or expired OTP.";
    }
}
?>

<!-- Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Smart Inventory</title>
    <link rel="stylesheet" href="css/reset.css">
</head>

<body>

<div class="reset-wrapper">

    <div class="reset-box">
        <h2>Reset Your Password</h2>
        <p>Enter your email, OTP, and your new password.</p>

        <form method="POST" action="reset_password.php">

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="Enter your email">
            </div>

            <div class="input-group">
                <label>OTP Code</label>
                <input type="text" name="otp" maxlength="6" required placeholder="Enter OTP">
            </div>

            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="new_password" required placeholder="Enter new password">
            </div>

            <button type="submit">Reset Password</button>

            <a href="forgot_password.php" class="back-link">Back</a>
        </form>

    </div>

</div>

</body>
</html>