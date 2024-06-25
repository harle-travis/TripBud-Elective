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
  <title>Insert Room Data</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .container {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .form-label {
      font-weight: bold;
    }
    .form-control {
      border-radius: 5px;
    }
    .btn-dark {
      background-color: #343a40;
      border-color: #343a40;
      border-radius: 5px;
    }
    .btn-dark:hover {
      background-color: #23272b;
      border-color: #1d2124;
    }
    .error {
      color: #dc3545;
      font-size: 0.9rem;
      margin-top: 5px;
    }
    .requirements {
      font-size: 0.9rem;
      color: #6c757d;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Insert Room Data</h2>
    <form method="POST" novalidate id="roomForm">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="room_name" class="form-label">Room Name</label>
          <input type="text" class="form-control mb-3" required name="room_name" id="room_name">
          <div class="error" id="room_name_error"></div>
        </div>
        <div class="col-md-6">
          <label for="price" class="form-label">Price</label>
          <input type="text" class="form-control mb-3" required name="price" id="price">
          <div class="error" id="price_error"></div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-4">
          <label for="room_size" class="form-label">Room Size</label>
          <input type="text" class="form-control mb-3" required name="room_size" id="room_size">
          <div class="error" id="room_size_error"></div>
        </div>
        <div class="col-md-4">
          <label for="num_rooms" class="form-label">Number of Rooms</label>
          <input type="number" class="form-control mb-3" required name="num_rooms" id="num_rooms">
          <div class="error" id="num_rooms_error"></div>
        </div>
        <div class="col-md-4">
          <label for="num_bathrooms" class="form-label">Number of Bathrooms</label>
          <input type="number" class="form-control mb-3" required name="num_bathrooms" id="num_bathrooms">
          <div class="error" id="num_bathrooms_error"></div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12">
          <label for="image_path" class="form-label">Room Image</label>
          <input type="file" class="form-control mb-3" required name="image_path" id="image_path">
          <div class="error" id="image_path_error"></div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12">
          <label class="form-label">Amenities</label>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="amenities[]" id="wifi" value="Wifi">
              <label class="form-check-label" for="wifi">Wifi</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="amenities[]" id="aircon" value="Aircon">
              <label class="form-check-label" for="aircon">Aircon</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="amenities[]" id="tv" value="Television">
              <label class="form-check-label" for="tv">Television</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="amenities[]" id="refrigerator" value="Refrigerator">
              <label class="form-check-label" for="refrigerator">Refrigerator</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="amenities[]" id="board_games" value="Board Games">
              <label class="form-check-label" for="board_games">Board Games</label>
            </div>
            <!-- Add more amenities checkboxes as needed -->
          </div>
          <div class="error" id="amenities_error"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-dark">
            Insert
          </button>
        </div>
      </div>
    </form>
    <!-- Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resultModalLabel">Submission Result</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="resultMessage"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');
    const resultModal = new bootstrap.Modal(document.getElementById('resultModal')); // Initialize modal
    const insertButton = document.querySelector('button[type="submit"]');


    form.addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form submission

      let isValid = true;

      // Validate Room Name
      const roomNameInput = document.getElementById('room_name');
      const roomName = roomNameInput.value.trim();
      const roomNameError = document.getElementById('room_name_error');
      if (roomName === '') {
        roomNameError.innerText = 'Room Name is required';
        isValid = false;
      } else {
        roomNameError.innerText = '';
      }

      // Validate Price
      const priceInput = document.getElementById('price');
      const price = priceInput.value.trim();
      const priceError = document.getElementById('price_error');
      if (price === '') {
        priceError.innerText = 'Price is required';
        isValid = false;
      } else {
        priceError.innerText = '';
      }

      // Validate Room Size
      const roomSizeInput = document.getElementById('room_size');
      const roomSize = roomSizeInput.value.trim();
      const roomSizeError = document.getElementById('room_size_error');
      if (roomSize === '') {
        roomSizeError.innerText = 'Room Size is required';
        isValid = false;
      } else {
        roomSizeError.innerText = '';
      }

      // Validate Number of Rooms
      const numRoomsInput = document.getElementById('num_rooms');
      const numRooms = numRoomsInput.value.trim();
      const numRoomsError = document.getElementById('num_rooms_error');
      if (numRooms === '') {
        numRoomsError.innerText = 'Number of Rooms is required';
        isValid = false;
      } else {
        numRoomsError.innerText = '';
      }

      // Validate Number of Bathrooms
      const numBathroomsInput = document.getElementById('num_bathrooms');
      const numBathrooms = numBathroomsInput.value.trim();
      const numBathroomsError = document.getElementById('num_bathrooms_error');
      if (numBathrooms === '') {
        numBathroomsError.innerText = 'Number of Bathrooms is required';
        isValid = false;
      } else {
        numBathroomsError.innerText = '';
      }

      // Validate Image Path
      const imagePathInput = document.getElementById('image_path');
      const imagePath = imagePathInput.value.trim();
      const imagePathError = document.getElementById('image_path_error');
      if (imagePath === '') {
        imagePathError.innerText = 'Image Path is required';
        isValid = false;
      } else {
        imagePathError.innerText = '';
      }

      // If form is valid, submit the form
      if (isValid) {
        // Collect form data
        const formData = new FormData(form);

        // Send form data using AJAX
        fetch('../php/create-room-process.php', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to submit form. Please try again later.');
          }
          return response.json();
        })
        .then(data => {
          console.log('Form submitted successfully:', data);
          // Optionally, display success message or redirect user
          // Show modal with submission result
          document.getElementById('resultMessage').textContent = data.message;
          resultModal.show();
          // Clear the form fields
          form.reset();
        })
        .catch(error => {
          console.error('An error occurred while submitting the form:', error);
          // Optionally, display error message to user
        })
        .finally(() => {
          // Re-enable the insert button
          insertButton.disabled = false;
        });
      }
    });

    // Add event listener to modal hidden event to reset form
    resultModal._element.addEventListener('hidden.bs.modal', function () {
      form.reset(); // Reset the form
    });
  });
  
</script>



</body>
</html>
