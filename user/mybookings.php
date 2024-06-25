<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>My bookings</title>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }


        .h-font {
            font-family: 'Merienda', cursive;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .swiper-container {
            width: 100%;
            height: 350px;
            object-fit: fill
        }

        .swiper-container-slide-img {
            object-fit: cover;
        }

        .btn.custom-bg {
            background-color: #2ec1ac;
        }

        .custom-bg:hover {
            background-color: #2ec12e;
        }

        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>
    <?php
  include('user-nav.php');
  ?>
    <section id="bookings">
        <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Your Bookings</h2>
        <div class="container">
            <div class="row">
                <?php
                include('../db/db.php'); // Include your database connection file

                // Retrieve bookings data from the database
                $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                $sql = "SELECT b.*, r.image_path, r.room_name 
                FROM bookings b 
                INNER JOIN rooms r ON b.room_id = r.room_id 
                WHERE b.user_id = $user_id AND b.status != 'Cancelled'"; // Exclude cancelled bookings
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Room Image">
                                <div class="card-body">
                                    <p>Room Name: <?php echo $row['room_name']; ?></p> <!-- Display the room name -->

                                    <p>Check-in Date: <?php echo $row['checkin_date']; ?></p>
                                    <p>Check-out Date: <?php echo $row['checkout_date']; ?></p>
                                    <p>Total Price: <?php echo $row['total_price']; ?></p>
<?php
// Check if payment has been made for this booking
$paymentSql = "SELECT * FROM payments WHERE booking_id = {$row['booking_id']}";

$paymentResult = $conn->query($paymentSql);

if ($paymentResult->num_rows > 0) {
    // Payment has been made
    $paymentRow = $paymentResult->fetch_assoc();
    if ($paymentRow['payment_status'] == 'Approved') {
        // Display "Print Booking Details" button
        echo "<button type=\"button\" class=\"btn btn-sm text-white shadow-none custom-bg print-booking-details-btn\" onclick=\"redirectToPDF({$row['booking_id']})\">Print Booking Details</button>";
    } elseif ($paymentRow['payment_status'] == 'Pending') {
        echo "<p>Payment has been made. Waiting for approval.</p>";
    }
} else {
    // Payment has not been made, display Pay Now button
    echo "<p>Status: {$row['status']}</p>";
    if ($row['status'] == 'Approved') {
        echo "<button type=\"button\" class=\"btn btn-sm text-white shadow-none custom-bg\" data-bs-toggle=\"modal\" data-bs-target=\"#payModal_{$row['booking_id']}\">Pay Now</button>";
    } elseif ($row['status'] == 'Pending') {
        // Display "Cancel Booking" button
        echo '<button type="button" class="btn btn-sm text-white shadow-none custom-bg cancel-booking-btn" data-booking-id="' . $row['booking_id'] . '">Cancel Booking</button>';
    }
}
?>

                                </div>
                            </div>
                        </div>

                        <!-- Pay Now Modal -->
                        <div class="modal fade" id="payModal_<?php echo $row['booking_id']; ?>" tabindex="-1" aria-labelledby="payModalLabel_<?php echo $row['booking_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="payModalLabel_<?php echo $row['booking_id']; ?>">Pay Now</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Left Side (Image) -->
                                            <div class="col-md-6">
                                                <img src="../QR/QR.jpg" class="img-fluid" alt="Room Image">
                                            </div>
                                            <!-- Right Side (Form) -->
                                            <div class="col-md-6">
                                                <form id="paymentForm_<?php echo $row['booking_id']; ?>" method="POST">
                                                    <!-- Add your payment form fields here -->
                                                    <input type="hidden" id="booking_id" name="booking_id" value="<?php echo $row['booking_id']; ?>">

                                                    <div class="mb-3">
                                                        <label for="gcash_number" class="form-label">GCash Number</label>
                                                        <input type="text" class="form-control" id="gcash_number" name="gcash_number">
                                                        <div id="gcashNumberError" class="text-danger error-message"></div> <!-- Error message for GCash number -->
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="reference_number" class="form-label">Reference Number</label>
                                                        <input type="text" class="form-control" id="reference_number" maxlength="11" name="reference_number">
                                                        <div id="referenceNumberError" class="text-danger error-message"></div> <!-- Error message for reference number -->
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="amount" class="form-label">Amount</label>
                                                        <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $row['total_price']; ?>" readonly>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No bookings found.</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <section id="cancelled-bookings">
        <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Your Cancelled Bookings</h2>
        <div class="container">
            <div class="row">
                <?php
                include('../db/db.php'); // Include your database connection file

                // Retrieve cancelled bookings data from the database
                $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                $sql = "SELECT b.*, r.image_path, r.room_name 
                FROM bookings b 
                INNER JOIN rooms r ON b.room_id = r.room_id 
                WHERE b.user_id = $user_id AND b.status = 'Cancelled'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Room Image">
                                <div class="card-body">
                                    <p>Room Name: <?php echo $row['room_name']; ?></p> <!-- Display the room name -->

                                    <p>Check-in Date: <?php echo $row['checkin_date']; ?></p>
                                    <p>Check-out Date: <?php echo $row['checkout_date']; ?></p>
                                    <p>Total Price: <?php echo $row['total_price']; ?></p>
                                    <p>Status: <?php echo $row['status']; ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No cancelled bookings found.</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../JS/index.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('form[id^="paymentForm"]').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Show confirmation dialog
                Swal.fire({
                    title: 'Confirm Payment Details',
                    text: 'Please make sure that all the details are correct before proceeding with the payment.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reset previous error messages
                        $(this).find('.error-message').text('');

                        // Get form data
                        var formData = $(this).serialize();

                        // Extract booking ID from the form
                        var bookingId = $(this).find('#booking_id').val();
                        formData += '&booking_id=' + bookingId;

                        // Perform input validation
                        var gcashNumber = $(this).find('#gcash_number').val().trim();
                        var referenceNumber = $(this).find('#reference_number').val().trim();

                        var isValid = true;

                        // GCash number validation
                        if (!validateGCashNumber(gcashNumber)) {
                            $(this).find('#gcashNumberError').text('Invalid GCash number');
                            isValid = false;
                        }

                        // Reference number validation
                        if (referenceNumber.length !== 11 || isNaN(referenceNumber)) {
                            $(this).find('#referenceNumberError').text('Reference number must be 11 digits');
                            isValid = false;
                        }

                        // If input validation passes, proceed with AJAX request
                        if (isValid) {
                            // Send AJAX request
                            $.ajax({
                                type: 'POST',
                                url: '../php/payment-process.php', // Update with your PHP script URL
                                data: formData,
                                success: function(response) {
                                    console.log(response); // Log the response object
                                    // Show SweetAlert notification based on response status
                                    if (response.status === "success") {
                                        // Payment Successful
                                        // Show success message and reload the page
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Successful',
                                            text: 'Thank you for your payment!',
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then(function() {
                                            location.reload();
                                        });
                                    } else {
                                        // Payment Failed
                                        // Show error message
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Payment Failed',
                                            text: response.message
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText); // Log the error message
                                    // Show error message
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong! Please try again later.'
                                    });
                                }
                            });
                        }
                    }
                });
            });

            // Function to validate GCash number format
            function validateGCashNumber(number) {
                var gcashRegex = /^(09|\+639)\d{9}$/;
                return gcashRegex.test(number);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle click event on cancel booking button
            $('.cancel-booking-btn').click(function() {
                // Get the booking ID from the button's data attribute
                var bookingId = $(this).data('booking-id');

                // Display the confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to cancel this booking.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    // If the user confirms cancellation
                    if (result.isConfirmed) {
                        // Send an AJAX request to cancel the booking
                        $.ajax({
                            type: 'POST',
                            url: '../php/cancel-booking.php', // Update with your cancellation script URL
                            data: {
                                booking_id: bookingId
                            },
                            success: function(response) {
                                // Handle the response from the cancellation script
                                if (response.status === "success") {
                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Booking Cancelled',
                                        text: 'Your booking has been cancelled.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(function() {
                                        // Reload the page after closing the popup
                                        location.reload();
                                    });
                                } else {
                                    // Display error message
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Display error message if AJAX request fails
                                Swal.fire('Error!', 'Failed to cancel booking. Please try again later.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function redirectToPDF(bookingId) {
            // Redirect to the PHP file that generates the PDF
            window.location.href = 'generate-pdf.php?bookingId=' + bookingId;
        }
    </script>

</body>

</html>