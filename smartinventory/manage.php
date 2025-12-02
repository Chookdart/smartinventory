<?php
session_start(); 
/*if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in."); 
}*/ //turn it on after testing phase
?>

<!DOCTYPE html>
    <head><title>Smart Inventory System - Manage Products</title></head>
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
        <h1>MANAGE PRODUCTS PANEL</h1>
        </div>

        <section class="selection">
            <div class="wrapper">
            <h1>SCHOOL SUPPLIES <br><br>
             <button id="editSchool">Edit</button>  </h1>  
            </div>
            
            <div class="wrapper2">
            <h1>FOOT & WEAR<br><br>
            <button id="editFoot">Edit</button> </h1>  
            </div>   

            <div class="wrapper3">
            <h1>SPORTS<br><br>  
            <button id="editSports">Edit</button>
            </div>
            
            <div class="wrapper4">
            <h1>SNACKS <br><br>
            <button id="editSnacks">Edit</button>
            </div>  
            
        </section>

            <div id="schoolModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeSchool">&times;</span>
                <h2>Manage School Supplies</h2>
                <p>Here you can add, edit, or delete school supply items.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>ID</th><th>Product Type</th><th>Category</th><th>Quantity</th>
                <th>Price</th><th>Brand</th><th>Date Added</th><th>Code</th></tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "smartinventory");
                $result = $conn->query("SELECT * FROM products WHERE category='School Supplies'");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
        <td>{$row['ProductID']}</td>
        <td>{$row['ProductType']}</td>
        <td>{$row['Category']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['UnitPrice']}</td>
        <td>{$row['Brand']}</td>
        <td>{$row['DateAdded']}</td> 
        <td>{$row['qr_code']}</td> 
        <td>
          <button class='editBtn'
              data-id='{$row['ProductID']}'
              data-type='{$row['ProductType']}'
              data-cat='{$row['Category']}'
              data-qty='{$row['quantity']}'
              data-price='{$row['UnitPrice']}'
              data-brand='{$row['Brand']}'
              data-code='{$row['qr_code']}'
          >Edit</button>
          <button class='deleteBtn' onclick=\"if(confirm('Delete this item?')) window.location.href='product_process.php?delete={$row['ProductID']}';\">Delete</button>
        </td>
      </tr>";

                }
                ?>
                </table>

                <br>
                <button class='add' onclick="location.href='add_product.php?category=School Supplies'">Add New Item</button>
            </div>
            </div>

            <!-- ✅ FOOT & WEAR MODAL -->
            <div id="footModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeFoot">&times;</span>
                <h2>Manage Foot & Wear</h2>
                <p>Here you can add, edit, or delete Foot & Wear items.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>ID</th><th>Product Type</th><th>Category</th><th>Quantity</th>
                <th>Price</th><th>Brand</th><th>Date Added</th><th>Code</th></tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "smartinventory");
                $result = $conn->query("SELECT * FROM products WHERE category='Foot & Wear'");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
        <td>{$row['ProductID']}</td>
        <td>{$row['ProductType']}</td>
        <td>{$row['Category']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['UnitPrice']}</td>
        <td>{$row['Brand']}</td>
        <td>{$row['DateAdded']}</td>
        <td>{$row['qr_code']}</td> 
        <td>
          <button class='editBtn'
              data-id='{$row['ProductID']}'
              data-type='{$row['ProductType']}'
              data-cat='{$row['Category']}'
              data-qty='{$row['quantity']}'
              data-price='{$row['UnitPrice']}'
              data-brand='{$row['Brand']}'
              data-code='{$row['qr_code']}'
          >Edit</button>
          <button class='deleteBtn' onclick=\"if(confirm('Delete this item?')) window.location.href='product_process.php?delete={$row['ProductID']}';\">Delete</button>
        </td>
      </tr>";
                }
                ?>

                 </table>
                <br>
                <button class='add' onclick="location.href='add_product.php?category=School Supplies'">Add New Item</button>
            </div>
            </div>

            <!-- ✅ SPORTS MODAL -->
            <div id="sportsModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeSports">&times;</span>
                <h2>Manage Sports</h2>
                <p>Here you can add, edit, or delete Sports items.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>ID</th><th>Product Type</th><th>Category</th><th>Quantity</th>
                <th>Price</th><th>Brand</th><th>Date Added</th><th>Code</th></tr>
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
                        <td>{$row['qr_code']}</td> 
                        <td>
                        <button class='editBtn'
                            data-id='{$row['ProductID']}'
                            data-type='{$row['ProductType']}'
                            data-cat='{$row['Category']}'
                            data-qty='{$row['quantity']}'
                            data-price='{$row['UnitPrice']}'
                            data-brand='{$row['Brand']}'
                            data-code='{$row['qr_code']}'
                        >Edit</button>
                        <button class='deleteBtn' onclick=\"if(confirm('Delete this item?')) window.location.href='product_process.php?delete={$row['ProductID']}';\">Delete</button>
                        </td>
                    </tr>"; 
                }
                ?>

                 </table>
                <br>
                <button class='add' onclick="location.href='add_product.php?category=School Supplies'">Add New Item</button>
            </div>
            </div>

            <!-- ✅ SNACKS MODAL -->
            <div id="snacksModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeSnacks">&times;</span>
                <h2>Manage Snacks</h2>
                <p>Here you can add, edit, or delete Snacks items.</p>

                <table border="1" cellspacing="0" cellpadding="8" style="width:100%;">
                <tr><th>ID</th><th>Product Type</th><th>Category</th><th>Quantity</th>
                <th>Price</th><th>Brand</th><th>Date Added</th><th>Code</th></tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "smartinventory");
                $result = $conn->query("SELECT * FROM products WHERE category='Snacks'");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['ProductID']}</td>
                        <td>{$row['ProductType']}</td>
                        <td>{$row['Category']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['UnitPrice']}</td>
                        <td>{$row['Brand']}</td>
                        <td>{$row['DateAdded']}</td>
                        <td>{$row['qr_code']}</td> 
                        <td>
                        <button class='editBtn'
                            data-id='{$row['ProductID']}'
                            data-type='{$row['ProductType']}'
                            data-cat='{$row['Category']}'
                            data-qty='{$row['quantity']}'
                            data-price='{$row['UnitPrice']}'
                            data-brand='{$row['Brand']}'
                            data-code='{$row['qr_code']}'
                        >Edit</button>
                        <button class='deleteBtn' onclick=\"if(confirm('Delete this item?')) window.location.href='product_process.php?delete={$row['ProductID']}';\">Delete</button>
                        </td>
                    </tr>";
                }
                ?>

                 </table>
                <br>
                <button class='add' onclick="location.href='add_product.php?category=School Supplies'">Add New Item</button>
            </div>
            </div>
                </table>
            </div>
        </div>

        <!-- EDIT PRODUCT MODAL -->
         <div id="editModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>Edit Product</h2>

                <form method="POST" action="product_process.php">
                    <input type="hidden" name="ProductID" id="editID">

                    <label>Product Type:</label>
                    <input type="text" name="ProductType" id="editType" required><br>

                    <label>Category:</label>
                    <input type="text" name="Category" id="editCategory" required><br>

                    <label>Quantity:</label>
                    <input type="text" name="quantity" id="editQty" required><br>

                    <label>Unit Price:</label>
                    <input type="text" name="UnitPrice" id="editPrice" required><br>

                    <label>Brand:</label>
                    <input type="text" name="Brand" id="editBrand" required><br>

                    <label>Code:</label>
                    <input type="text" name="qr_code" id="editCode" required><br>

                    <button type="submit" name="update_product">Save Changes</button>
                    
                </form>
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

            const editModal = document.getElementById("editModal");
            const editButtons = document.querySelectorAll(".editBtn");

            // When an Edit button is clicked
            editButtons.forEach(button => {
            button.addEventListener("click", () => {
                document.getElementById("editID").value = button.dataset.id;
                document.getElementById("editType").value = button.dataset.type;
                document.getElementById("editCategory").value = button.dataset.cat;
                document.getElementById("editQty").value = button.dataset.qty;
                document.getElementById("editPrice").value = button.dataset.price;
                document.getElementById("editBrand").value = button.dataset.brand;
                document.getElementById("editCode").value = button.dataset.code;
                editModal.style.display = "block";
            });
            });

            // Close modal
            function closeEditModal() {
            editModal.style.display = "none";
            }

            // Close when clicking outside
            window.onclick = function(event) {
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
            };

           
        </script>
    </body>
</html>