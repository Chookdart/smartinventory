
<!DOCTYPE html>
<html>
    <head><title>Login Smart Inventory</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
 
    <body>
        <!--login--> 
        <div class="wrapper">
            <div class="form-header">
                <div class="titles">
                    <div class="title-login">LOGIN</div>
                    <div class="title-register">Register</div>
                </div>
            </div>
            <form action="login.php" class="login-form" method="post" autocomplete="off">
                <div class="input-box">
                <input type="text" class="input-field" id="email" name="email" required>
                <label for="log-email" class="label">Email</label>
                <i class="bx bx-envelope icon"></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" id="password" name="password" required>
                <label for="log-pass" class="label">Password</label>
                <i class="bx bx-lock-alt icon"></i>

                <!-- Eye icon to toggle password -->
                <i class='bx bx-show toggle-password' onclick="togglePasswordVisibility(this, 'password')"></i>
            </div>
 
            <div class="form-cols"> 
                <div class="col-1"></div>
                 <div class="col-2">
                    <a href="forgot_password.php">Forgot Password</a>
                </div>
            </div>
            <div class="input-box">
               <!-- LOGIN BUTTON FIX -->
<button class="btn-submit" type="submit" id="loginBtn" name="create">Sign In <i class='bx bx-log-in'></i></button>

            </div>
        </form>
    <!--
        <form action="test.php" class="register-form" method="post" autocomplete="off">
            <div class="input-box">
                <input type="text" class="input-field" id="reg-name" name="reg-name" required>
                <label for="reg-name" class="label">Username</label>
                <i class="bx bx-user icon"></i>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" id="reg-email" name="reg-email" required>
                <label for="reg-email" class="label">Email</label>
                <i class="bx bx-envelope icon"></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" id="reg-pass" name="reg-pass" required>
                <label for="reg-pass" class="label">Password</label>
                <i class="bx bx-lock-alt icon"></i>



                <i class='bx bx-show toggle-password' onclick="togglePasswordVisibility(this, 'reg-pass')"></i>
            </div>
            <div>
                <small id="passwordHelp" style="color: #888; font-size: 12px; display: block;">
    * Must have 1 lowercase, 1 capital letter, 1 number, and min 8 characters.
</small>

            </div>

        
            <div class="form-cols">
                <div class="col-1">
                    <input type="checkbox" id="agree" required>
                    <label for="agree"> I agree to terms & conditions</label>
                </div>
                <div class="col-2"> </div>
            </div>
            <div class="input-box">
                <button class="btn-submit" type="submit" id="SignUpBtn">Sign Up <i class='bx bx-log-out'></i> </button>
            </div>
            <div class="switch-form">
                <span>Already have an account? <a href="#" onclick="loginFunction()">Login</a></span>
            </div>
        </form>
</div>

-->
    
</div>

<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">


    function togglePasswordVisibility(icon, fieldId) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bx-show");
        icon.classList.add("bx-hide");
    } else {
        input.type = "password";
        icon.classList.remove("bx-hide");
        icon.classList.add("bx-show");
    }
}


function validatePassword(password) {
    const letter = /[a-z]/.test(password);
    const capital = /[A-Z]/.test(password);
    const number = /[0-9]/.test(password);
    const minLength = password.length >= 8;
    return letter && capital && number && minLength;
}

$(document).ready(function(){

    let failedAttempts = 0;
    let lockoutTimer; 
    // LOGIN
    $('#loginBtn').click(function(e){
        e.preventDefault();

        var email = $('#email').val();
        var password = $('#password').val();


         if (email === '' || password === '') {
        Swal.fire('Missing Fields', 'Please enter both email and password.', 'warning');
        return;
    }

        $.ajax({
            type: 'POST',
            url: 'dbprocess.php',
            data: {
                'action': 'login',
                'email': email,
                'password': password
            },
            success: function(data) {
            console.log('Response:', data);
            

            const role = data.trim();
            //
        if (role === "Admin" || role === "Staff" || role === "Cashier") {
            failedAttempts = 0;

        // Close the popup and redirect to homepage
        Swal.fire({
            title: 'Success',
            text: 'Login Successful!',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            if (role === 'Admin') {
            window.location.href = "homepage.php";
            } else if (role === 'Staff') {
                window.location.href = "homepage.php";
            } else if (role === 'Cashier') {
                window.location.href = "cashier.php";
            }
        });
    } else {
        failedAttempts++;
if (failedAttempts >= 3) {
                    $('#loginBtn').prop('disabled', true);
                    Swal.fire('Too Many Attempts', 'Login disabled for 15 seconds.', 'warning');

                    lockoutTimer = setTimeout(() => {
                        $('#loginBtn').prop('disabled', false);
                        failedAttempts = 0;
                    }, 15000); // 15 seconds
                } else {
                    Swal.fire('Error', data, 'error');
                }
    }
},
            error: function(){
                Swal.fire('Error', 'Login failed', 'error');
            }
        });
    });

});
</script>


</body>
</html>

