<?php
session_start();

// Check if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page or any other page
    header("Location: admin-index.php");
    exit(); // Stop further execution
}

// If admin is logged in, you can continue displaying the page content
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Create Admin</title>
    <style>
        body {
    margin: 0;
    padding: 0;
    height: 100vh;
    overflow: hidden; /* This prevents scrollbars from appearing */
}

        .container {
            width: 650px;
            height: auto;

        }
    </style>
      <style>
        form {
            max-width: 400px;
            height:390px;
            margin: 0 auto;
            padding: 20px;
            height:auto;
        }

        h2.newAdmin {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-weight: bold;
            color: #555;
        }

      

        #error-message {
            margin-bottom: 20px;
        }

        .regbtn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        .regbtn:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <?php
    include('nav.php');
    ?>
    <div class="col-md-9 mt-5 d-flex justify-content-center" id="mainContent">
        <div class="row d-flex mt-5 justify-content-center container">
        <form class="mt-1" id="regForm">
            <h2 class="newAdmin">Create new Admin</h2>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="name" class="form-control" name="name" id="name" >
                <div id="name-error" class="text-danger"></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" >
                <div id="email-error" class="text-danger"></div>
            </div>
            <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password">
                        <span class="input-group-text">
                            <i class="bx bxs-show toggle-password" id="togglePassword" style="width: 24px; height: 24px;"></i>
                        </span>
                    </div>
                    <div id="password-error" class="text-danger"></div>
                </div>
            <div class="d-flex align-items-center justify-content-end mb-2">
                <button type="submit" class="regbtn btn-dark">Register</button>
            </div>
        </form>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include Boxicons JS -->
    <script src="https://cdn.jsdelivr.net/boxicons/2.0.7/boxicons.min.js"></script>
    <!-- Include custom JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
$(document).ready(function(){
    // Email and password validation
    $('#regForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        var email = $('#email').val();
        var password = $('#password').val();
        var name = $('#name').val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var nameRegex = /^[A-Za-z\-\'\s]+$/;
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        if (!nameRegex.test(name)) {
            $('#name-error').text('Please enter a valid name.');
            return; // Exit the function if NAME is invalid
        } else {
            $('#name-error').text(''); // Clear error message
        }

        // Check if email is valid
        if (!emailRegex.test(email)) {
            $('#email-error').text('Please enter a valid email address.');
            return; // Exit the function if email is invalid
        } else {
            $('#email-error').text(''); // Clear error message
        }

        // Check if password meets requirements
        if (!passwordRegex.test(password)) {
            $('#password-error').text('Password must contain at least 8 characters, including 1 uppercase letter, 1 lowercase letter, and 1 digit.');
            return; // Exit the function if password is invalid
        } else {
            $('#password-error').text(''); // Clear error message
        }

        // If both email and password requirements are met, submit the form via AJAX
        $.ajax({
            url: '../php/create-admin-acc.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                // Display success message using SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response,
                });

                // Reset form fields
                $('#regForm')[0].reset();
            },
            error: function(xhr, status, error){
                // Check if the error status code is 409 (Conflict)
                if (xhr.status === 409) {
                    // Display error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Email already exists.',
                    });
                } else {
                    // Display generic error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseText || 'An error occurred while processing your request.',
                    });
                }
            }
        });
    });
});
</script>


    <script>
        document.getElementById("sidebarCollapse").addEventListener("click", function() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        });
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const menuText = document.querySelectorAll('.menu-text');
            const mainContent = document.getElementById('mainContent');

            sidebarCollapse.addEventListener('hide.bs.collapse', function() {
                menuText.forEach(function(text) {
                    text.classList.add('visually-hidden');
                });
                mainContent.classList.add('main-content-expanded');
            });

            sidebarCollapse.addEventListener('show.bs.collapse', function() {
                menuText.forEach(function(text) {
                    text.classList.remove('visually-hidden');
                });
                mainContent.classList.remove('main-content-expanded');
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            const mainContent = document.getElementById('mainContent');

            sidebarCollapse.addEventListener('click', function() {
                mainContent.classList.toggle('col-md-9-expanded');
            });
        });
    </script>
 <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle icon class
        var icon = document.getElementById('togglePassword');
        if (type === 'password') {
            icon.classList.remove('bxs-hide');
            icon.classList.add('bxs-show');
        } else {
            icon.classList.remove('bxs-show');
            icon.classList.add('bxs-hide');
        }
    });
</script>


</body>

</html>