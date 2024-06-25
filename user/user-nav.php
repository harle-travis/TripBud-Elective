<?php include('../db/db.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    /* CSS styles for the notification container */
    .notification-container {
        display: none; /* Hide by default */
        position: absolute;
        top: calc(100% + 5px); /* Position below the button */
        left: 80%;
        transform: translateX(-80%);
        z-index: 1000; /* Ensure it appears above other elements */
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 10px;
        
    }

    .notification-container.show {
        display: block; /* Show when toggled */
    }
    
</style>
    <title>Nav</title></head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
    <img src="../img/1.png" alt="logo"/>
        <a class="left navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">TripBud</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="left2 collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active'; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'facilities.php') echo 'active'; ?>" href="facilities.php" id="facilities-link">About</a>
                </li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'food.php') echo 'active'; ?>" href="food.php">Food</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'rooms.php') echo 'active'; ?>" href="rooms.php" id="rooms-link">Places</a>
                            </li>
                <?php endif; ?>
                <li class="nav-item ">
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'contactus.php') echo 'active'; ?>" href="contactus.php" id="contactus-link">Contacts</a>
                </li>
              
            </ul>
            <div class="d-flex">
                <!-- Check if user is logged in -->
                <?php if (isset($_SESSION['user_id'])) : ?>

                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" id="logoutButton">Logout</button>
                <?php else : ?>
                    <!-- User is not logged in, show login and register buttons -->
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>


  <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="loginForm">


          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-fill fs-3 me-2"></i> Client Login
            </h5>
            <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control shadow-none" name="email" id="email">
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control shadow-none" name="password" id="password">
            </div>
            <div id="error-message" class="text-danger"></div>

            <div class="d-flex align-items-center justify-content-between mb-2">
              <button class="btn btn-dark shadow-none">Login</button>
              <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password</a>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

  <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="registrationForm">
          <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center">
              <i class="bi bi-person-lines-fill fs-3 me-2"></i> Client Register

            </h5>
            <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: Your details must match with your Identification Card that will be required during check-in.
            </span>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 ps-0 mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" class="form-control shadow-none" required name="name" id="name">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control shadow-none" required name="email" required id="email">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control shadow-none" required name="password" id="password">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="confirmPassword" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control shadow-none" required name="confirmpassword" id="confirmPassword">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input type="number" class="form-control shadow-none" required name="phone" id="phone">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="birthdate" class="form-label">Birthdate</label>
                  <input type="date" class="form-control shadow-none" required name="birthdate" id="birthdate">
                </div>

                <div class="col-md-12 ps-0 mb-3">
                  <label for="address" class="form-label">Address</label>
                  <textarea type="text" class="form-control shadow-none" required name="address" id="address" rows="1"></textarea>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="postalcode" class="form-label">Postal Code</label>
                  <input type="text" class="form-control shadow-none" required name="postalcode" id="postalcode">
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label for="id" class="form-label">Identification Card</label>
                  <input type="file" class="form-control shadow-none" required name="id" id="id">
                </div>
              </div>
              <div class="text-end my-l mb-3">
                <button type="submit" class="btn btn-dark shadow-none">
                  Register
                </button>

              </div>
            </div>

        </form>

      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="../JS/index.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to the button and notification container
        var button = document.getElementById("notificationButton");
        var container = document.getElementById("notificationContainer");

        // Function to toggle visibility of the container
        function toggleContainer() {
            container.classList.toggle("show");
            if (container.classList.contains("show")) {
                fetchNotification();
            }
        }

        // Event listener for button click to toggle container visibility
        button.addEventListener("click", toggleContainer);

        // Function to fetch notifications from the server
        function fetchNotification() {
            // Make an AJAX request to fetch notifications
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        container.innerHTML = xhr.responseText;
                    } else {
                        console.error('Error fetching notifications:', xhr.status);
                    }
                }
            };
            xhr.open('GET', '../php/fetch-notification.php', true);
            xhr.send();
        }
        $('#notificationButton').click(function() {
        // Send AJAX request to mark notifications as read
        $.ajax({
            url: '../php/mark-as-read.php',
            method: 'POST',
            success: function(response) {
                // Update the badge count on the bell icon
                $('#notificationBadge').text('0');
                
                // Fetch updated notifications
                fetchNotification();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error, if any
            }
        });
    });
    $(document).ready(function() {
    // Function to update the notification badge count
    function updateNotificationBadge() {
        $.ajax({
            url: '../php/unread-notif.php', // Path to your PHP script that fetches the count of unread notifications
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                // Update the badge count with the fetched count
                $('#notificationBadge').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error, if any
            }
        });
    }

    // Call the function initially to set the badge count
    updateNotificationBadge();

    // Event listener for mouse enter on the notification button
    $('#notificationButton').mouseenter(function() {
        // Update the badge count
        updateNotificationBadge();
    });
});

    });
   
</script>
</body>
</html>