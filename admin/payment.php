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
<title>Payment Approval</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<style>
    .custom-icon{
        font-size: 15px !important;
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
        <h2 class="text-center mb-4">Payment Approval</h2>
        <div class="table-responsive py-2">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-light">
                    <tr>
                        <th>Payment ID</th>
                        <th>Booking ID</th>
                        <th>User ID</th>
                        <th>Payment Date</th>
                        <th>GCash Number</th>
                        <th>Reference Number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../db/db.php';

                    // Step 2: Retrieve data with payment details
                    $sql = "SELECT * FROM payments WHERE payment_status = 'Pending'";
                    $result = $conn->query($sql);

                    // Step 3: Display data
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr id='paymentRow_".$row["payment_id"]."'> <!-- Add id attribute here -->
                                    <td>".$row["payment_id"]."</td>
                                    <td>".$row["booking_id"]."</td>
                                    <td>".$row["user_id"]."</td>
                                    <td>".$row["payment_date"]."</td>
                                    <td>".$row["gcash_number"]."</td>
                                    <td>".$row["reference_number"]."</td>
                                    <td>".$row["amount"]."</td>
                                    <td>".$row["payment_status"]."</td>
                                    <td>
                                        <div class='d-flex'>
                                            <button class='btn btn-success me-2' onclick='confirmApproval(".$row["payment_id"].")'>    <i class='bx bx-check custom-icon'></i>                                            </i></button>
                                            <button class='btn btn-danger' onclick='confirmRejection(".$row["payment_id"].")'><i class='bx bx-x custom-icon'></i></button>
                                        </div>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No pending payments found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // JavaScript code to handle AJAX request for approving payment
   // JavaScript code to handle AJAX request for approving payment
function approvePayment(paymentId) {
    // AJAX request to approve payment
    $.ajax({
        url: '../php/approve-payment.php', // Path to your PHP script
        type: 'POST',
        data: { paymentId: paymentId },
        dataType: 'json',
        success: function(response) {
            // Display result using SweetAlert2
            Swal.fire({
                icon: response.status === 'success' ? 'success' : 'error',
                title: response.message,
                showConfirmButton: false,
                timer: 2000
            });
            // Update status cell in table row if the payment is approved
            if(response.status === 'success') {
                $('#paymentRow_' + paymentId + ' td:eq(7)').text('Approved'); // Update the index if needed
            }
        },
        error: function(xhr, status, error) {
            // Display error message if AJAX request fails
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to approve payment: ' + error,
            });
        }
    });
}


    // JavaScript code to handle AJAX request for rejecting payment
   // JavaScript code to handle AJAX request for rejecting payment
function rejectPayment(paymentId) {
    // SweetAlert2 confirmation for rejecting payment
   
            $.ajax({
                url: '../php/reject-payment.php', // Path to your PHP script
                type: 'POST',
                data: { paymentId: paymentId },
                dataType: 'json',
                success: function(response) {
                    // Display result using SweetAlert2
                    Swal.fire({
                        icon: response.status === 'success' ? 'success' : 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    // Update status cell in table row if the payment is rejected
                    if(response.status === 'success') {
                        $('#paymentRow_' + paymentId + ' td:eq(7)').text('Rejected'); // Update the index if needed
                    }
                },
                error: function(xhr, status, error) {
                    // Display error message if AJAX request fails
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to reject payment: ' + error,
                    });
                }
            });
        }


    // SweetAlert2 confirmation for approving payment
    function confirmApproval(paymentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Once approved, this payment status will be updated!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                approvePayment(paymentId);
            }
        });
    }

    // SweetAlert2 confirmation for rejecting payment
    function confirmRejection(paymentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Once rejected, this payment status will be updated!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                rejectPayment(paymentId);
            }
        });
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
