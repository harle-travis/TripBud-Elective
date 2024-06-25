<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-image: url('../slider/1.jpg');
      background-size: cover;
      background-repeat: no-repeat;
    }
  </style>
</head>
<body>
<div class="container mt-5 px-lg-5 py-lg-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div id="loginDiv" class="card">
        <div class="card-header">
          <h5 class="card-title d-flex align-items-center">
            <i class="bi bi-person-fill fs-3 me-2"></i> Admin Login
          </h5>
        </div>
        <div class="card-body">
          <form id="loginForm">

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
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission behavior
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;

  var xhr = new XMLHttpRequest();
  xhr.open('POST', '../php/admin-login.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === 'success') {
          // Display success message using SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'Login Successful!',
            text: 'Redirecting to calendar page...',
            timer: 1500, // Set the timer to automatically close the alert after 1.5 seconds
            showConfirmButton: false // Hide the confirm button
          }).then(() => {
            window.location.href = "calendar.php"; // Change to the desired URL
          });
        } else {
          // Display error message using SweetAlert
          Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: response.message
          });
        }
      } else {
        // Error occurred during request
        console.error('Error occurred during request');
      }
    }
  };
  var formData = 'email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password);
  xhr.send(formData);
});

</script>
</body>
</html>