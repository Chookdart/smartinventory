<?php 
// NOTE: Assuming your database connection will be available throughout the script.
$conn = new mysqli("localhost", "root", "", "smartinventory");

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Corrected the typo: $$_GET['Category'] is now $_GET['Category']
$category = isset($_GET['Category']) ? $_GET['Category'] : 'All Products';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add Product - <?php echo htmlspecialchars($category); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Link to the new product specific CSS file -->
        <link rel="stylesheet" href="css/add_product.css">
        <!-- Boxicons for icons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class="wrapper">
            <!-- Form container matching the centralized card design -->
            <div class="form-card">
                <div class="header">
                    <h2>Add New Item</h2>
                    <p>Enter the details for the new inventory item.</p>
                </div>

                <form action="product_process.php" method="Post">
                    <input type="hidden" name="Category" value="<?php echo htmlspecialchars($category); ?>">
                    
                    <!-- Product Type -->
                    <div class="input-box">
                        <input type="text" name="ProductType" id="ProductType" class="input-field" placeholder="" required>
                        <label for="ProductType" class="label">Product Type</label>
                    </div>

                    <!-- Category (Dropdown uses the same styling structure) -->
                    <div class="input-box select-box">
                        <select name="Category" id="Category" class="input-field" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="School Supplies">School Supplies</option>
                            <option value="Foot & Wear">Foot & Wear</option>
                            <option value="Sports">Sports</option>
                            <option value="Snacks">Snacks</option>
                        </select>
                        <label for="Category" class="label select-label-hack">Category</label>
                    </div>

                    <!-- Quantity -->
                    <div class="input-box">
                        <input type="number" name="quantity" id="quantity" class="input-field" min="1" required>
                        <label for="quantity" class="label">Quantity</label>
                    </div>

                    <!-- Unit Price -->
                    <div class="input-box">
                        <input type="number" name="UnitPrice" id="UnitPrice" class="input-field" step="0.01" min="0" required>
                        <label for="UnitPrice" class="label">Unit Price</label>
                    </div>

                    <!-- Brand -->
                    <div class="input-box">
                        <input type="text" name="Brand" id="Brand" class="input-field" required>
                        <label for="Brand" class="label">Brand</label>
                    </div>
                    
                    <!-- Supplier -->
                    <div class="input-box select-box">
                        <select name="SupplierID" id="SupplierID" class="input-field" required>
                            <option value="" disabled selected>-- Select Supplier --</option>
                            <?php
                            $suppliers = $conn->query("SELECT SupplierID, SupplierName FROM suppliers");
                            if ($suppliers) {
                                while ($s = $suppliers->fetch_assoc()) {
                                    echo "<option value='{$s['SupplierID']}'>{$s['SupplierName']}</option>";
                                }
                            }
                            // Note: The main database connection remains open here
                            ?>
                        </select>
                        <label for="SupplierID" class="label select-label-hack">Supplier</label>
                    </div>

                    <!-- Code -->
                    <div class="input-box">
                        <input type="text" name="qr_code" id="qr_code" class="input-field" required>
                        <label for="qr_code" class="label">Code</label>
                    </div>
                    
                    <button type="submit" name="add_product" class="btn-submit">
                        <i class='bx bx-plus-circle'></i> Add Product
                    </button>
                </form>

                <div class="back-link">
                    <a href="manage.php">Back to Manage Products</a>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
// Closing the main connection at the end of the script
$conn->close(); 
?>