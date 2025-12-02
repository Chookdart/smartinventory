<?php
session_start();

if (!isset($_SESSION['UserRole']) || $_SESSION['UserRole'] !== 'Admin'){
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
    <head><title>Admin Panel</title></head>
    <link rel="stylesheet" href="css/style.css" />

    <body>
        <section class="hero">
            <nav>
                <img src="pics/logo/wisdom logo.png" class="logo">
                <h2 class="name">SMART INVENTORY</h2>
                        <img src="pics/logo/vj.jpg" class="user-pic" onclick="toggleMenu()">
                        

                    <div class="sub-menu-wrap" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img src="pics/logo/vj.jpg">
                                <h2>Vie Jhay</h2>
                            </div>
                                <hr>

                            <a href="#"  class="sub-menu-link">
                                <img src="images/profile.png">
                                <p>Edit Profile</p>
                                <span>></span>
                            </a>
                            <a href="#"  class="sub-menu-link">
                                <img src="images/profile.png">
                                <p>Settings & Privacy</p>
                                <span>></span> 
                            </a>
                            <a href="#"  class="sub-menu-link">
                                <img src="images/profile.png">
                                <p>Log Out</p>
                                <span>></span>
                            </a>
                                
                        </div>
                    </div>
           
            </nav>
            <nav class="secondary-nav">
                        <a>name</a>
                        <a>date</a>
                        <a>time</a>
            </nav>
            <nav class="nav-left">
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="sample.php">Manage Products</a></li>
                    <li><a>Manage Suppliers</a></li>
                    <li><a href="sample.php">Admin Access</a></li>
                    <li><a>Logout</a></li> 
                </ul>            
            </nav>  
            
        </section>      
        <section>
            <div class="body">
                <h1>WELCOME TO THE ADMIN PANEL!!!</h1>
          
            </div>
        </section>

        
         <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu(){
                subMenu.classList.toggle("open-menu");
            }
        </script>
    </body>
</html>