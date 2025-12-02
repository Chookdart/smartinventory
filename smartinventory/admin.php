<?php
include 'db.php';
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;

?>
 
<!DOCTYPE html>
    <head><title>Smart Inventory System - Reports</title></head>
    <link rel="stylesheet" href="css/admin.css" />

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
        <h1>ADMIN ACCESS PANEL</h1><br>
                    </div>

        <section class="selection">
            
          <!-- ✅ SUPPLIER PERFORMANCE REPORT -->

            <div class="db">
            <div class="db-content"></div>

                <table>
                <tr><th>ID</th><th>Roles</th><th>email</th>
                <?php
               
                $query = "SELECT *                
                    FROM users";

                    $result = mysqli_query($conn, $query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['Roles']}</td>
                            <td>{$row['email']}</td>

                            <td>
                            <button class='editBtn'
                            data-id='{$row['ID']}'
                            data-roles='{$row['Roles']}'
                            data-email='{$row['email']}'>Edit</button>
                            
                            <button class='deleteBtn' onclick=\"if(confirm('Delete this item?'))window.location.href='admin_process.php?delete={$row['ID']}';\">Delete</button>
                        </td>
                            </tr>";
                }
                ?>
                </table>
                <br>
                <button class="add" onclick="location.href='add_users.php?'">Add Users</button>
                </div>
           
</div>
      
                    


        </section>

         <div id="editModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>Edit Users</h2>

                <form method="POST" action="admin_process.php">
                    <input type="hidden" name="ID" id="editID">

                    <label>Roles:</label>
                    <input type="text" name="Roles" id="editRoles" required><br>

                    <label>Email:</label>
                    <input type="text" name="email" id="editEmail" required><br>

                    <label>Password:</label>
                    <input type="text" name="password" id="editPasswodr" required><br>

                    <button type="submit" name="update_user">Save Changes</button>
                    
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
                document.getElementById("editRoles").value = button.dataset.roles;
                document.getElementById("editEmail").value = button.dataset.email;
                
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