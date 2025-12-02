<?php 
$conn = new mysqli("localhost", "root", "", "smartinventory");

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// Corrected typo: $$_GET['Category'] is now $_GET['Category']
$category = isset($_GET['Category']) ? $_GET['Category'] : '';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Title adjusted to reflect the content (Add Users) -->
        <title>Add Users</title>
        <meta name="description" content="Add new users to the inventory system.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Linking to the modern CSS file (css/add_users.css) -->
        <link rel="stylesheet" href="css/users.css">
        <!-- Boxicons and Poppins Font for modern aesthetics -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    </head>
    <body>
        <!-- Use .wrapper and .form-card for the centralized, modern layout -->
        <div class="wrapper">
            <div class="form-card">
                <div class="header">
                    <h2>Add New System User</h2>
                    <p>Assign roles and credentials for new team members.</p>
                </div>

                <form action="admin_process.php" method="Post">
                    
                    <!-- Roles Dropdown (using input-box and select-box for floating label styling) -->
                    <div class="input-box select-box">
                       <select name="Roles" id="Roles" class="input-field" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="Admin">Admin</option>
                            <!-- Note: The value for Cashier is corrected to 'Cashier' from 'Staff' -->
                            <option value="Staff">Staff</option>
                            <option value="Cashier">Cashier</option>
                        </select>
                        <label for="Roles" class="label select-label-hack">Role</label>
                    </div>

                    <!-- Email Input (using input-box for floating label styling) -->
                    <div class="input-box">
                        <input type="email" name="email" id="email" class="input-field" placeholder="" required>
                        <label for="email" class="label">Email</label>
                    </div>

                    <!-- Password Input (using input-box for floating label styling) -->
                    <div class="input-box">
                        <input type="password" name="password" id="password" class="input-field" placeholder="" required>
                        <label for="password" class="label">Password</label>
                    </div>

                    <!-- Submit Button (using btn-submit class) -->
                    <button type="submit" name="add_users" class="btn-submit">
                        <i class='bx bx-user-plus'></i> Add User
                    </button>
                </form>

                <div class="back-link">
                    <a href="admin.php">Back to Admin Panel</a>
                </div>
            </div>
        </div>
    </body>
</html>