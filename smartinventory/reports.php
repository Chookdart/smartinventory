<?php
include 'db.php';
session_start(); 
/*if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in."); 
}*/ //turn it on after testing phase
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

?>
 
<!DOCTYPE html>
    <head><title>Smart Inventory System - Reports</title></head>
    <link rel="stylesheet" href="css/style.css" />

    <body>
        <section class="hero">
            <nav class="nav-left">
                 <div class="title">SMART INVENTORY <br><span class="second-line">SYSTEM</span>
                <ul>
                    <li><a href="homepage.php">DASHBOARD</a></li>
                    <li><a href="manage.php">MANAGE PRODUCTS</a></li>
                    <li><a href="reports.php">REPORTS</a></li>
                    <li><a href="cashier.php">CASHIER</a></li>
                    <?php if (isset($_SESSION['UserRole']) && $_SESSION['UserRole'] === 'Admin'): ?>           
                    <li><a href="admin.php">ADMIN ACCESS</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">LOGOUT</a></li> 
                </ul>            
            </nav>  
            
        </section>      
        
        <div class="page-header">
        <h1>REPORTS PANEL</h1>
        </div>

        <section class="selection">
            <div class="wrapper">
            <h1>SUPPLIER PERFORMANCE <br><br>
             <button id="editSchool">View Details</button>  </h1>  
            </div>
            
            <div class="wrapper2">
            <h1>RECENTLY ADDED ITEMS<br><br>
            <button id="editFoot">View Details</button> </h1>  
            </div>   

            <div class="wrapper3">
            <h1>CATEGORY SUMMARY<br><br>  
            <button id="editSports">View Details</button>
            </div>
            
            <div class="wrapper4">
            <h1>TRANSACTION HISTORY <br><br>
            <button id="editSnacks">View Details</button>
            </div>  
            
        </section>
             <!-- ✅ SUPPLIER PERFORMANCE REPORT -->
            <div id="schoolModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeSchool">&times;</span>
                <h2>Supplier Performance Report</h2>
                <p>Here are the rankings of the most to least suppliers.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>Supplier Name</th><th>Total Items Supplied</th><th>Total Categories</th><th>Last Delivery</th>
                <?php
               
                $query = "SELECT s.SupplierName,
                    SUM(p.quantity) AS TotalItems,
                    COUNT(DISTINCT p.Category) AS TotalCategories,
                    MAX(p.DateAdded) AS LastDelivery
                    
                    FROM suppliers s
                    JOIN products p ON s.SupplierID = p.SupplierID
                    GROUP BY s.SupplierName
                    ORDER BY TotalItems DESC";

                    $result = mysqli_query($conn, $query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['SupplierName']}</td>
                            <td>{$row['TotalItems']}</td>
                            <td>{$row['TotalCategories']}</td>
                            <td>{$row['LastDelivery']}</td>
                        </tr>";
                }
                ?>
                </table>

                <br>
                  <form method="post" action="supplier_report.php" target="_blank">
                <button class="print" type="submit" name="supplier_report">Print PDF</button>
                </form>

            </div>
            </div> 

            <!-- ✅ RECENTLY ADDED ITEMS -->
            <div id="footModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeFoot">&times;</span>
                <h2>Recently Added Items</h2>
                <p>Here are the lists of recently added items.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>ID</th><th>Product Type</th><th>Category</th><th>Quantity</th>
                <th>Price</th><th>Brand</th><th>Date Added</th></tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "smartinventory");
                $result = $conn->query("SELECT * FROM products WHERE category='Sports'");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ProductID']}</td>
                            <td>{$row['ProductType']}</td>
                            <td>{$row['Category']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['UnitPrice']}</td>
                            <td>{$row['Brand']}</td>
                            <td>{$row['DateAdded']}</td>
                        </tr>";
                }
                
                ?>
                </table>

                <br>
                <form method="post" action="recentlyadded_reports.php" target="_blank">
                <button class="print" type="submit" name="recentlyadded_reports">Print PDF</button>
                </form>

            </div>
            </div>

            <!-- ✅ CATEGORY SUMMARY -->
            <div id="sportsModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeSports">&times;</span>
                <h2>Category Summary</h2>
                <p>Here are the summaries of each category from inventory.</p>

                
                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>Category</th><th>No. of Products</th>
                <th>Total Quantity</th><th>Average Price</th>
                <?php
               
                $query = "SELECT Category,
                    COUNT(*) AS ProductCount,
                    SUM(quantity) AS TotalQuantity,
                    ROUND(AVG(UnitPrice), 2) AS AveragePrice

                    FROM products
                    GROUP BY Category";

                    $result = mysqli_query($conn, $query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['Category']}</td>
                            <td>{$row['ProductCount']}</td>
                            <td>{$row['TotalQuantity']}</td>
                            <td>{$row['AveragePrice']}</td>
                        </tr>";
                }
                ?>

                 </table>
                <br>

                <form method="post" action="category_report.php" target="_blank">
                <button class="print" type="submit" name="generate_report">Print PDF</button>
                </form>

            </div>
            </div>

            <!-- ✅ TRANSACTION HISTORY MODAL -->
            <div id="snacksModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeSnacks">&times;</span>
                <h2>Transaction History Modal</h2>
                <p>Here you can see and download the transaction history for important purposes.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>TransactionID</th><th>Product</th><th>Quantity</th><th>Date</th>

                <?php
                $query = "SELECT p.ProductID, p.ProductType, p.quantity, p.DateAdded
                            FROM products p
                            ORDER BY p.DateAdded DESC";

                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<tr>
                    <td>{$row['ProductID']}</td>
                    <td>{$row['ProductType']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['DateAdded']}</td>
                    ";
                }
                ?>

                 </table>
                <br>
                <form method="post" action="transaction_report.php" target="_blank">
                <button class="print" type="submit" name="transaction_report">Print PDF</button>
                </form>
            </div>
            </div>
                </table>
            </div>
        </div>
        
         <script>
          //  let subMenu = document.getElementById("subMenu");
      // MODAL TEST //    document.getElementById("schoolModal").style.display = "block";

            document.addEventListener("DOMContentLoaded", () => {
            const modals = {
                editSchool: "schoolModal",
                editFoot: "footModal",
                editSports: "sportsModal",
                editSnacks: "snacksModal"
            };

            Object.keys(modals).forEach((btnId) => {
                const btn = document.getElementById(btnId);
                const modal = document.getElementById(modals[btnId]);
                const closeBtn = modal.querySelector(".close");

                // Show modal when button is clicked
                btn.addEventListener("click", () => {
                modal.style.display = "block";
                });

                // Hide when clicking the X
                closeBtn.addEventListener("click", () => {
                modal.style.display = "none";
                });

                // Hide when clicking outside
                window.addEventListener("click", (event) => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
                });
            });
            });

       
        </script>
    </body>
</html>