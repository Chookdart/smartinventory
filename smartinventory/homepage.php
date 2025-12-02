<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
    <head><title>Smart Inventory System - Dashboard</title></head>
    <link rel="stylesheet" href="css/style.css" />

    <body>
        <section class="hero">
            <nav class="nav-left">
                 <div class="title">SMART INVENTORY <br><span class="second-line">SYSTEM</span>
                <ul>
                    <li><a href="homepage.php">DASHBOARD</a></li>
                    <li><a href="manage.php">MANAGE PRODUCTS</a></li>
                    <li><a href="reports.php">REPORTS</a></li>
                    <?php if (isset($_SESSION['UserRole']) && $_SESSION['UserRole'] === 'Admin'): ?>    
                    <li><a href="cashier.php">CASHIER</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['UserRole']) && $_SESSION['UserRole'] === 'Admin'): ?>           
                    <li><a href="admin.php">ADMIN ACCESS</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">LOGOUT</a></li> 
                </ul>            
            </nav>  
            
        </section>      

        <div class="page-header">
        <h1>DASHBOARD PANEL</h1>
        </div>

        <section class="selection">
            <div class="wrapper">
            <h1>TOTAL PRODUCTS<br><br>
            <?php  
            $conn = new mysqli("localhost", "root", "", "smartinventory");

            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            $sql = "SELECT SUM(quantity) AS total_quantity FROM products";
            $result = $conn->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                echo "<p>" . $row['total_quantity'] . "</p>";
            } else {
                echo "<p>0</p>";
            }

            ?>   </h1>  
            </div>
            
            <div class="wrapper2">
            <h1>TOTAL SUPPLIERS <br><br>
            <?php  

            $result2 = mysqli_query($conn, "SELECT COUNT(SupplierName) AS total_suppliers FROM suppliers");
            $row2 = mysqli_fetch_assoc($result2);
                echo "<p>" . ($row2['total_suppliers'] ?? 0) . "</p>";


            ?>   </h1>   
            </div>   

            <div class="wrapper3">
            <h1>LOW-STOCK ALERTS<br><br>  
            <?php 

            $result3 = mysqli_query($conn, "SELECT * FROM products WHERE quantity <= 10");
            $lowStockCount = mysqli_num_rows($result3);

            // Show the number
            echo "<p>$lowStockCount</p>";

            // Hidden modal container
            echo '<div id="lowStockModal" class="modal">';
            echo '<div class="modal-content">';
            echo '<span class="close">&times;</span>';
            echo '<h2>Low-stock Products</h2>';
 
            if ($lowStockCount > 0) {
                while ($row3 = mysqli_fetch_assoc($result3)) {
                echo "<p>" . htmlspecialchars($row3['Brand']) . " (" . $row3['quantity'] . ")</p>";
                }
            } else {
                echo "<p>All stocks sufficient</p>";
            }

            echo '</div></div>';
            ?>

            <button id="viewLowStock">View Details</button>
            </div>
            
            <div class="wrapper4">
            <h1>RECENTLY ADDED ITEMS<br><br>
            <?php
        

            // Select products added within the last 15 days
            $query = "
                SELECT * 
                FROM products 
                WHERE DateAdded >= DATE_SUB(NOW(), INTERVAL 15 DAY)
            ";
            $result4 = mysqli_query($conn, $query);

            // Count recent items
            $recentCount = mysqli_num_rows($result4);

            // Display number only on dashboard
            echo "<p>$recentCount</p>";

            // Hidden modal for details
            echo '<div id="recentModal" class="modal">';
            echo '<div class="modal-content">';
            echo '<span class="close recentClose">&times;</span>';
            echo '<h2>Recently Added Products</h2>';

            if ($recentCount > 0) {
                while ($row4 = mysqli_fetch_assoc($result4)) {
                echo "<p>" . htmlspecialchars($row4['Brand']) . 
                    " — Added on " . date("M d, Y", strtotime($row4['DateAdded'])) . "</p>";
                }

            } else {
                echo "<p>No new items in the last 15 days.</p>";
            }

            echo '</div></div>';
            ?>

            <button id="viewRecent">View Details</button>
            </div>  
            
        </section>

        
         <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
     }
                const modal = document.getElementById("lowStockModal");
                const btn = document.getElementById("viewLowStock");
                const span = document.querySelector(".close");

                btn.onclick = () => modal.style.display = "block";
                span.onclick = () => modal.style.display = "none";
                window.onclick = (event) => {
                if (event.target === modal) modal.style.display = "none";

                }
                const recentModal = document.getElementById("recentModal");
                const recentBtn = document.getElementById("viewRecent");
                const recentClose = document.querySelector(".recentClose");

                recentBtn.onclick = () => recentModal.style.display = "block";
                recentClose.onclick = () => recentModal.style.display = "none";
                window.onclick = (event) => {
                if (event.target === recentModal) recentModal.style.display = "none";
                };


       
        </script>
    </body>
</html>