<?php 

session_start();
$UserID = $_SESSION['UserID'] ?? null;

if (!$UserID) {
    die("Error: No logged-in user found. Please log in first.");
}

$conn = new mysqli ("localhost", "root", "", "smartinventory");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
/*
if (isset($_Get['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE ProductID = $id");
    header("Location: manage.php");
    exit();
}*/

if (isset($_POST['add_product'])) {
    $ProductType = $_POST['ProductType'];
    $Category = $_POST['Category'];
    $quantity = intval($_POST['quantity']);
    $UnitPrice = intval($_POST['UnitPrice']);
    $Brand = $_POST['Brand'];
    $SupplierID = intval($_POST['SupplierID']);
    $qr_code = $_POST['qr_code'];

    $UserID = $_SESSION['UserID'] ?? null;



     if (!$UserID) {
        die("Error: No logged-in user found. Please log in first.");
    }

    // ✅ Insert record
    $sql = "INSERT INTO products (ProductType, Category, quantity, UnitPrice, Brand, UserID, SupplierID, DateAdded, qr_code)
            VALUES ('$ProductType', '$Category', $quantity, $UnitPrice, '$Brand', $UserID, $SupplierID, NOW(), '$qr_code')";

    if ($conn->query($sql)) {
        echo "<script>alert('Product added successfully!'); window.location='manage.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['saveProduct'])) {
    $ProductType = $_POST['ProductType'];
    $Category = $_POST['Category'];
    $UnitPrice = $_POST['UnitPrice'];
    $Brand = $_POST['Brand'];
    $DateAdded = $_POST['DateAdded'];
    $qr_code = $_POST['qr_code'];
    $conn->query("INSERT INTO products (product_name, quantity, price) VALUES ('$name', '$qty', '$price')");
    header("Location: manage_products.php");
}

if (isset($_GET['delete'])) {
  $ProductID = $_GET['delete'];
  $conn->query("DELETE FROM products WHERE ProductID=$ProductID");
  header("Location: manage.php");
}

if (isset($_POST['update_product'])) {
    $id = $_POST['ProductID'];
    $type = $_POST['ProductType'];
    $cat = $_POST['Category'];
    $qty = $_POST['quantity'];
    $price = $_POST['UnitPrice'];
    $brand = $_POST['Brand'];
    $qr_code = $_POST['qr_code'];

    $sql = "UPDATE products
    SET ProductType='$type', Category='$cat', quantity=$qty, UnitPrice=$price, Brand='$brand', qr_code='$qr_code'
    WHERE ProductID=$id";

    if ($conn->query($sql)) {
        echo "<script>alert('Product updated successfully!'); window.location='manage.php';</script>";

    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>