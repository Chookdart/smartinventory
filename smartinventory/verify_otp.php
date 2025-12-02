<?php
session_start();
date_default_timezone_set("Asia/Manila");
require 'db.php';

// Check if session email exists
if (!isset($_SESSION['reset_email'])) {
    die("No reset request found. Please try again.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $otp = trim($_POST['otp']);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp_code = ? AND otp_expiry >= NOW()");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->fetch_assoc()) {

        // OTP is valid
        $_SESSION['otp_verified'] = true;

          header("Location: http://localhost/dashboard/smartinventory/reset_password.php");
    exit();

    } else {
        echo "<p style='color:red;'>Invalid or expired OTP.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - Smart Inventory</title>
    <link rel="stylesheet" href="css/verify.css">
</head>

<body>

<div class="otp-wrapper">

    <div class="otp-box">
        <h2>Verify OTP</h2>
        <p>Enter the one-time password (OTP) sent to your email.</p>

        <form method="POST" action="verify_otp.php">

            <div class="input-group">
                <label>OTP Code</label>
                <input type="text" name="otp" maxlength="6" required placeholder="Enter 6-digit OTP">
            </div>

            <button type="submit">Verify OTP</button>

            <a href="forgot_password.php" class="back-link">Back</a>
        </form>

    </div>

</div>

</body>
</html>
