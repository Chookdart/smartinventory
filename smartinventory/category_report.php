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

$query = "SELECT Category,
                    COUNT(*) AS ProductCount,
                    SUM(quantity) AS TotalQuantity,
                    ROUND(AVG(UnitPrice), 2) AS AveragePrice

                    FROM products
                    GROUP BY Category";

                    $result = mysqli_query($conn, $query);


$html = "<h2>Category Summary Reports</h2>
        <p>Here are the summaries of each category from inventory.</p>
        <table border='1' cellspacing='0' cellpadding='8' width='100%'>
        <tr><th>Category</th><th>No. of Products</th>
                <th>Total Quantity</th><th>Average Price</th></tr>";
// HTML for PDF

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    $html .= "<tr>
                            <td>{$row['Category']}</td>
                            <td>{$row['ProductCount']}</td>
                            <td>{$row['TotalQuantity']}</td>
                            <td>{$row['AveragePrice']}</td>
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
