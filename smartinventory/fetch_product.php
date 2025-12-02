<?php
require "db.php";

if (!isset($_GET['id'])) {
    echo json_encode(null);
    exit;
}

$qr = $_GET['id'];

$stmt = $conn->prepare("SELECT 
        ProductID, 
        ProductType AS ProductName, 
        UnitPrice AS Price, 
        quantity 
    FROM products 
    WHERE qr_code = ?");
$stmt->bind_param("s", $qr);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(null);
}
?>
