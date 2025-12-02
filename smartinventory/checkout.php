<?php
ob_start(); // IMPORTANT: Prevents accidental output

require "db.php";
session_start();

require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Get cart data
$cart = json_decode(file_get_contents("php://input"), true);

if (!$cart || count($cart) === 0) {
    die("Cart empty");
}

// Compute total
$totalAmount = 0;
foreach ($cart as $item) {
    $totalAmount += $item['subtotal'];
}

// Insert into sales
$cashierID = $_SESSION['CashierID'] ?? 1;

$stmt = $conn->prepare("INSERT INTO sales (CashierID, TotalAmount, Date) VALUES (?, ?, NOW())");
$stmt->bind_param("id", $cashierID, $totalAmount);
$stmt->execute();
$saleID = $stmt->insert_id;

// Insert sales_items + deduct stock
foreach ($cart as $item) {
    $stmt_item = $conn->prepare("INSERT INTO sales_items (SaleID, ProductID, Quantity, Price) 
                                 VALUES (?, ?, ?, ?)");
    $stmt_item->bind_param("iiid", $saleID, $item['ID'], $item['qty'], $item['price']);
    $stmt_item->execute();

    $upd = $conn->prepare("UPDATE products SET Quantity = Quantity - ? WHERE ProductID = ?");
    $upd->bind_param("ii", $item['qty'], $item['ID']);
    $upd->execute();
}

// ------ PDF GENERATION ------
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// === Your HTML Receipt HERE ===
// (Use the receipt HTML I gave earlier)
$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 14px; }
    .center { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 6px; border-bottom: 1px solid #ddd; text-align: left; }
    .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 10px; }
</style>

<div class="center">
    <h2>Smart Inventory</h2>
    <p>Official Receipt</p>
    <p>Sale ID: '.$saleID.'</p>
    <p>Date: '.date("Y-m-d H:i").'</p>
</div>

<table>
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
    </tr>';

foreach ($cart as $item) {
    $html .= "
    <tr>
        <td>{$item['name']}</td>
        <td>{$item['qty']}</td>
        <td>" . number_format($item['price'], 2) . "</td>
        <td>" . number_format($item['subtotal'], 2) . "</td>
    </tr>";
}

$html .= '
</table>

<p class="total">TOTAL: '.number_format($totalAmount, 2).'</p>

<div class="center">
    <p>Thank you for your purchase!</p>
</div>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// IMPORTANT: No echo, no HTML, no spaces
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename='receipt-$saleID.pdf'");

echo $dompdf->output();

exit(); // STOP SCRIPT TO PREVENT EXTRA OUTPUT
