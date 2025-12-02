<?php 

include 'db.php';
session_start();
$UserID = $_SESSION['UserID'] ?? null;

if (!$UserID) {
    die("Error: No logged-in user found. Please log in first.");
}

$conn = new mysqli ("localhost", "root", "", "smartinventory");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}


if (isset($_GET['delete'])) {
  $ID = intval($_GET['delete']);

  $check = $conn->query("SELECT * FROM users WHERE ID=$ID");
  if ($check->num_rows > 0){
    if ($conn->query("DELETE FROM users WHERE ID=$ID"))
  echo "<script>alert('User deleted successfully!'); window.location='admin.php';</script>";
  } else {
    echo "<script>alert('Error deleting user: ' " . $conn->error . "'); window.location='admin.php';</script>";

  }
  
} else {
    echo "<script>alert('User not found!'); window.location='admin.php';</script>";
}

if (isset($_POST['update_user'])) {
    $ID = $_POST['ID'];
    $Roles = $_POST['Roles'];
    $email = $_POST['email'];
    $password = $_POST['password'];

      $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users
    SET Roles='$Roles', email='$email', password='$hashed'
    WHERE ID=$ID";

    if ($conn->query($sql)) {
        echo "<script>alert('Users updated successfully!'); window.location='admin.php';</script>";

    } else {
        echo "Error updating record: " . $conn->error;
    }

}
    // ADD USERS 

   if (isset($_POST['add_users'])) {
    $Roles = $_POST['Roles'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (Roles, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Roles, $email, $hashed);
    if($stmt->execute()) {
        echo "<script>alert('User added successfully!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " .$stmt->error . "');</script>";
    }
    $stmt->close();


}

?>