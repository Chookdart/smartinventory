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

$query = "SELECT * FROM products WHERE category='Sports'";

        $result = mysqli_query($conn, $query);

$html = "<h2>Recently Added Items</h2>
        <p>Here are the lists of recently added items.</p>
        <table border='1' cellspacing='0' cellpadding='8' width='100%'>
        <tr><th>ID</th><th>Product Type</th><th>Category</th><th>Quantity</th>
                <th>Price</th><th>Brand</th><th>Date Added</th></tr>";
// HTML for PDF

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    $html .= "<tr>
                            <td>{$row['ProductID']}</td>
                            <td>{$row['ProductType']}</td>
                            <td>{$row['Category']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['UnitPrice']}</td>
                            <td>{$row['Brand']}</td>
                            <td>{$row['DateAdded']}</td>
                        </tr>";
        }

    } else {
        $html .= "<tr><td colspan='7'>No data available</td></tr>";
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
$dompdf->stream("Inventory_Report.pdf", ["Attachment" => 0]);
?>
