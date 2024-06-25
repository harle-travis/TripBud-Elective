
var swiper = new Swiper(".swiper-container", {
  spaceBetween: 30,
  effect: "fade",
  loop: true,
  autoplay: {
    delay: 3500,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});



document.addEventListener('DOMContentLoaded', function() {
  // Get the registration form
  const registrationForm = document.getElementById('registrationForm');

  // Add event listener for form submission
  registrationForm.addEventListener('submit', function(event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Gather form data
    const formData = new FormData(registrationForm);

    // Log the form data being sent
    for (const [key, value] of formData.entries()) {
      console.log(key + ': ' + value);
    }

    // Send AJAX request to the PHP script
    fetch('../php/registration-process.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json()) // Parse response as JSON
      .then(data => {
        // Check if registration was successful
        if (data.success) {
          // Display the registration result using SweetAlert2
          Swal.fire({
            title: 'Registration Result',
            text: data.message,
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            // Refresh the page after the user clicks OK
            window.location.reload();
          });
        } else {
          // Display error message using SweetAlert2
          Swal.fire({
            title: 'Error',
            text: data.message,
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      })
      .catch(error => {
        console.error('Error:', error);
        // Display error message using SweetAlert2
        Swal.fire({
          title: 'Error',
          text: 'An error occurred while processing your request.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      });
  });
});



document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Fetch all input elements and log their values
    var inputs = document.querySelectorAll('#registrationForm input, #registrationForm textarea, #registrationForm select');
    inputs.forEach(function(input) {
      console.log(input.id + ': ' + input.value);
    });

    // Optionally, you can submit the form programmatically or perform other actions here

  });
});
document.getElementById('loginForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission behavior
  var email = document.getElementById('email').value;
  var password = document.getElementById('password').value;

  var xhr = new XMLHttpRequest();
  xhr.open('POST', '../php/login-process.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === 'success') {
          // Display success message
          document.getElementById('error-message').innerHTML = "Login successful!";
          // Reload the page after a short delay
          setTimeout(function() {
            location.reload();
          }, 1000); // 1000 milliseconds = 1 second
        } else {
          // Display error message
          document.getElementById('error-message').innerHTML = response.message;
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


// Add an event listener to the logout button
document.getElementById("logoutButton").addEventListener("click", function() {
  // Send an AJAX request to logout.php to destroy the session
  fetch('../user/logout.php', {
      method: 'POST'
    })
    .then(response => {
      // Redirect to the home page or do further processing
      window.location.href = '../user/index.php';
    })
    .catch(error => console.error('Error:', error));
});
