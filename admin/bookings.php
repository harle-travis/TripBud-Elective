<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Approval</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;

        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
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


<?php
include('nav.php');
?>

        <!-- Main content -->
        <div class="col-md-9 mt-5" id="mainContent">
        <div class="container">

    <h2 class="text-center mb-4">Booking Approval</h2>
    <div class="table-responsive py-2">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-light">
                <tr>
                    <th>Booking ID</th>
                    <th>Room</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                    <th>Number of Adults</th>
                    <th>Number of Children</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../db/db.php';

                // Step 2: Retrieve data with room name
                $sql = "SELECT b.*, r.room_name 
                FROM bookings b
                INNER JOIN rooms r ON b.room_id = r.room_id
                WHERE b.status = 'Pending'";
        
        $result = $conn->query($sql);
    
        // Step 3: Display data
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr id='bookingRow_".$row["booking_id"]."'> <!-- Add id attribute here -->
                        <td>".$row["booking_id"]."</td>
                        <td>".$row["room_name"]."</td>
                        <td>".$row["checkin_date"]."</td>
                        <td>".$row["checkout_date"]."</td>
                        <td>".$row["checkin_time"]."</td>
                        <td>".$row["checkout_time"]."</td>
                        <td>".$row["num_adults"]."</td>
                        <td>".$row["num_children"]."</td>
                        <td>".$row["total_price"]."</td>
                        <td>".$row["status"]."</td>
                        <td>
                            <div class='d-flex'>
                                <button class='btn btn-success me-2' onclick='approveBooking(".$row["booking_id"].")'><i class='bi bi-check-lg'></i></button>
                                <button class='btn btn-danger' onclick='rejectBooking(".$row["booking_id"].")'><i class='bi bi-x'></i></button>
                            </div>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='11' class='text-center'>No pending bookings found</td></tr>";
        }
    
        $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="statusAlert" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Status Update</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Alert message will be displayed here -->
        </div>
    </div>
</div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    // JavaScript code to handle AJAX request for approving booking
function approveBooking(bookingId) {
    // AJAX request to approve booking
    $.ajax({
        url: '../php/approve-booking.php', // Path to your PHP script
        type: 'POST',
        data: { bookingId: bookingId },
        dataType: 'json',
        success: function(response) {
            // Check if message exists in response
            if(response.hasOwnProperty('message')) {
                // Update status cell in table row
                $('#bookingRow_' + bookingId + ' td:eq(9)').text('Approved'); // Update the index if needed
                // Display status update message
                displayStatusUpdate(response.message, 'success');
            } else {
                // Display error message if message is not found in response
                displayStatusUpdate('Error: Invalid response format!', 'danger');
            }
        },
        error: function(xhr, status, error) {
            // Display error message if AJAX request fails
            displayStatusUpdate('Error: ' + error, 'danger');
        }
    });
}

// JavaScript code to handle AJAX request for rejecting booking
function rejectBooking(bookingId) {
    // AJAX request to reject booking
    $.ajax({
        url: '../php/reject-booking.php', // Path to your PHP script
        type: 'POST',
        data: { bookingId: bookingId },
        dataType: 'json',
        success: function(response) {
            // Check if message exists in response
            if(response.hasOwnProperty('message')) {
                // Update status cell in table row
                $('#bookingRow_' + bookingId + ' td:eq(9)').text('Rejected'); // Update the index if needed
                // Display status update message
                displayStatusUpdate(response.message, 'success');
            } else {
                // Display error message if message is not found in response
                displayStatusUpdate('Error: Invalid response format!', 'danger');
            }
        },
        error: function(xhr, status, error) {
            // Display error message if AJAX request fails
            displayStatusUpdate('Error: ' + error, 'danger');
        }
    });
}


    // JavaScript code to trigger the display of status updates
function displayStatusUpdate(message, type) {
    var toastBody = document.querySelector('#statusAlert .toast-body');
    toastBody.innerHTML = message;
    
    var toast = new bootstrap.Toast(document.getElementById('statusAlert'), {
        animation: true,
        autohide: true,
        delay: 3000 // Adjust the delay as needed
    });

    toastBody.className = 'toast-body alert-' + type; // Apply Bootstrap alert color classes
    toast.show();
}
document.getElementById("sidebarCollapse").addEventListener("click", function() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");
});
document.addEventListener('DOMContentLoaded', function () {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const menuText = document.querySelectorAll('.menu-text');
    const mainContent = document.getElementById('mainContent');

    sidebarCollapse.addEventListener('hide.bs.collapse', function () {
        menuText.forEach(function (text) {
            text.classList.add('visually-hidden');
        });
        mainContent.classList.add('main-content-expanded');
    });

    sidebarCollapse.addEventListener('show.bs.collapse', function () {
        menuText.forEach(function (text) {
            text.classList.remove('visually-hidden');
        });
        mainContent.classList.remove('main-content-expanded');
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const mainContent = document.getElementById('mainContent');

    sidebarCollapse.addEventListener('click', function () {
        mainContent.classList.toggle('col-md-9-expanded');
    });
});

</script>

</body>
</html>
