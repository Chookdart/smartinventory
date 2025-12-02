<?php
//require_once 'dompdf/autoload.inc.php';
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf
$dompdf = new Dompdf();

// Connect to database
$conn = new mysqli("localhost", "root", "", "smartinventory");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example: Fetch category summary

 $query = "SELECT p.ProductID, p.ProductType, p.quantity, p.DateAdded
                            FROM products p
                            ORDER BY p.DateAdded DESC";

                $result = mysqli_query($conn, $query);

$html = "<h2>Transaction History Modal</h2>
            <p>Here you can see and download the transaction history for important purposes.</p>
            <table border='1' cellspacing='0' cellpadding='8' width='100%'>
                <tr><th>TransactionID</th><th>Product</th><th>Quantity</th><th>Date</th></tr>";
// HTML for PDF

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    $html .= "<tr>
                    <td>{$row['ProductID']}</td>
                    <td>{$row['ProductType']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['DateAdded']}</td>
                    </tr>";
        }

    } else {
        $html .= "<tr><td colspan='4'>No data available</td></tr>";
    }
$html .= "</table>";

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Output to browser (force download)
$dompdf->stream("Inventory_Report.pdf", array("Attachment" => 0));
?>
