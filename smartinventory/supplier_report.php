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

$query = "SELECT s.SupplierName,
                    SUM(p.quantity) AS TotalItems,
                    COUNT(DISTINCT p.Category) AS TotalCategories,
                    MAX(p.DateAdded) AS LastDelivery
                    
                    FROM suppliers s
                    JOIN products p ON s.SupplierID = p.SupplierID
                    GROUP BY s.SupplierName
                    ORDER BY TotalItems DESC";

                    $result = mysqli_query($conn, $query);


        $html = "<h2 style='text-align:center;'>Supplier Performance Reports</h2>
                <p>Here are the rankings of the most to least suppliers.</p>
                <table border='1' cellspacing='0' cellpadding='8' style='width:100%;'>
                <tr><th>Supplier Name</th><th>Total Items Supplied</th>
                <th>Total Categories</th><th>Last Delivery</th></tr>";
// HTML for PDF

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                    $html .= "<tr>
                            <td>{$row['SupplierName']}</td>
                            <td>{$row['TotalItems']}</td>
                            <td>{$row['TotalCategories']}</td>
                            <td>{$row['LastDelivery']}</td>
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
