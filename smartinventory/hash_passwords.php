<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartinventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT ID, password FROM users");

while ($row = $result->fetch_assoc()) {
    $id = $row['ID'];
    $pass = $row['password'];

    // Skip already hashed passwords (they usually start with $2y$ or $argon2)
    if (preg_match('/^\$2y\$|^\$argon2/', $pass)) {
        continue;
    }

    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    $conn->query("UPDATE users SET password='$hashed' WHERE ID=$id");
}

echo "✅ Passwords successfully hashed!";
$conn->close();
?>