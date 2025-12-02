<?php
session_start();
ob_start();
require_once('db.php'); // your DB connection


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare statement to get user by email
    $stmt = $conn->prepare("SELECT ID, Roles, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($password === $row['password'] || password_verify($password, $row['password'])) {
        $_SESSION['UserID'] = $row['ID'];
        $_SESSION['UserRole'] = trim($row['Roles']); // trim to remove spaces

        echo trim($row['Roles']); // send role back to JS
        exit();
    }

    } else {
        echo "Incorrect Password.";
    }

    $stmt->close();
    $conn->close(); 
}
?>
