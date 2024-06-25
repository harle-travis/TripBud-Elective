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
  <title>Calendar</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    #calendar {
      min-width: 900px; /* Increased maximum width */
      max-width: auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .calendar-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .calendar-select {
      margin-bottom: 10px;
    }

    .calendar-select select {
      padding: 5px;
    }

    .calendar-table {
      width: 100%;
      height: 450px;
      border-collapse: collapse;
    }

    .calendar-table th,
    .calendar-table td {
      justify-content:center; 
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
      width: 14.28%; /* Equal width for each day */
    }

    .calendar-table th {
      background-color: #f2f2f2;
    }

    .calendar-table td {
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      
    }

    .calendar-table td:hover {
      background-color: #f2f2f2;
    }

    td.current-day {
      background-color: cadetblue;
    }
    
    /* New class for booked dates */
    td.booked {
      background-color: #ff8080; /* Adjust as needed */
    }
    .status-colors-container {
    display: flex;
    flex-wrap: wrap;
}

.status-color {
    margin-right: 10px; /* Adjust spacing between badges */
    margin-bottom: 10px; /* Adjust spacing between rows */
    display: flex;
    align-items: center;
}

.status-label {
    margin-left: 5px; /* Adjust spacing between badge and label */
}

  </style>
</head>
<body>
<?php
include('nav.php');
?>
        <div class="col-md-9 mt-5" id="mainContent">
        <div class="status-colors-container">
    <div class="status-color">
        <span class="badge bg-success">Approved</span>
        <span class="status-label"> - for approved bookings</span>
    </div>
    <div class="status-color">
        <span class="badge bg-warning">Pending</span>
        <span class="status-label"> - for pending bookings</span>
    </div>
    <div class="status-color">
        <span class="badge bg-danger">Cancelled</span>
        <span class="status-label"> - for cancelled bookings</span>
    </div>
    <div class="status-color">
        <span class="badge bg-info">Ongoing</span>
        <span class="status-label"> - for ongoing bookings</span>
    </div>
    <div class="status-color">
        <span class="badge bg-primary">Completed</span>
        <span class="status-label"> - for completed bookings</span>
    </div>
    <div class="status-color">
        <span class="badge bg-secondary">Other</span>
        <span class="status-label"> - for other statuses</span>
    </div>
</div>

    <div class="row d-flex mt-2 justify-content-center">
      <div id="calendar"></div>
    </div>
  <!-- Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr>
            <th>Check-in Date:</th>
            <td id="checkinDate"></td>
          </tr>
          <tr>
            <th>Checkout Date:</th>
            <td id="checkoutDate"></td>
          </tr>
          <tr>
            <th>Check-in Time:</th>
            <td id="checkinTime"></td>
          </tr>
          <tr>
            <th>Checkout Time:</th>
            <td id="checkoutTime"></td>
          </tr>
          <tr>
            <th>Number of Adults:</th>
            <td id="numAdults"></td>
          </tr>
          <tr>
            <th>Number of Children:</th>
            <td id="numChildren"></td>
          </tr>
          <tr>
            <th>Total Price:</th>
            <td id="totalPrice"></td>
          </tr>
          <tr>
            <th>Status:</th>
            <td id="status"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer" id="modalFooter">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 $(document).ready(function() {
    var bookedData; // Define bookedData variable in a higher scope

    renderCalendar(); // Call renderCalendar function when the document is ready

    function renderCalendarForMonthYear(year, month, bookedData) {
        var calendarDiv = $('#calendar');
        var calendarTable = $('<table>').addClass('table calendar-table').append(
            $('<thead>').append(
                $('<tr>').append(
                    $('<th>').text('Sun'),
                    $('<th>').text('Mon'),
                    $('<th>').text('Tue'),
                    $('<th>').text('Wed'),
                    $('<th>').text('Thu'),
                    $('<th>').text('Fri'),
                    $('<th>').text('Sat')
                )
            ),
            $('<tbody>')
        );

        var firstDayOfMonth = new Date(year, month, 1);
        var lastDayOfMonth = new Date(year, month + 1, 0);
        var daysInMonth = lastDayOfMonth.getDate();
        var firstDayOfWeek = firstDayOfMonth.getDay();

        var dateCounter = 1;
        var row = $('<tr>');
        for (var i = 0; i < 42; i++) { // 6 rows, 7 days each
            var cellClass = '';
            if (i >= firstDayOfWeek && dateCounter <= daysInMonth) {
                var currentDate = new Date(); // Get the current date
                currentDate.setHours(0, 0, 0, 0); // Set hours, minutes, seconds, and milliseconds to zero for accurate comparison
                var cellDate = new Date(year, month, dateCounter); // Construct the current date
                if (cellDate.getTime() === currentDate.getTime()) { // Compare the dates
                    cellClass = 'current-day';
                }
                var cell = $('<td>').addClass(cellClass).text(dateCounter);
                // Check if the date is booked and append the badge with check-in and check-out times
                var formattedDate = getFormattedDate(year, month, dateCounter);
                var bookingsForDate = bookedData.filter(data => data.checkin_date === formattedDate);

                if (bookingsForDate.length > 0) {
                    // If there are multiple bookings for the same date, loop through each one
                    bookingsForDate.forEach(bookingInfo => {
                        var checkinTime = new Date(bookingInfo.checkin_date + ' ' + bookingInfo.checkin_time);
                        var checkoutTime = new Date(bookingInfo.checkout_date + ' ' + bookingInfo.checkout_time);
                        var formatter = new Intl.DateTimeFormat('en-US', { hour: 'numeric', minute: 'numeric' });
                        var formattedCheckinTime = formatter.format(checkinTime);
                        var formattedCheckoutTime = formatter.format(checkoutTime);

                        // Create a badge element
                        var badge = $('<span>').addClass('badge rounded-pill text-dark').text(formattedCheckinTime + ' - ' + formattedCheckoutTime);

// Set the badge color based on the booking status
switch (bookingInfo.status) {
    case 'Approved':
        badge.addClass('bg-success'); // Green color for approved bookings
        break;
    case 'Pending':
        badge.addClass('bg-warning'); // Yellow color for pending bookings
        break;
    case 'Cancelled':
        badge.addClass('bg-danger'); // Red color for cancelled bookings
        break;
    case 'Ongoing':
        badge.addClass('bg-info'); // Blue color for ongoing bookings
        break;
    case 'Completed':
        badge.addClass('bg-primary'); // Blue color for completed bookings
        break;
    default:
        badge.addClass('bg-secondary'); // Default color for other statuses
        break;
}


                        // Add a click event listener to the badge
                        badge.click(function() {
    // Open the modal
    $('#bookingModal').modal('show');

    // Populate modal with booking details
    
    $('#checkinDate').text(bookingInfo.checkin_date);
    $('#checkoutDate').text(bookingInfo.checkout_date);
    $('#checkinTime').text(bookingInfo.checkin_time);
    $('#checkoutTime').text(bookingInfo.checkout_time);
    $('#numAdults').text(bookingInfo.num_adults);
    $('#numChildren').text(bookingInfo.num_children);
    $('#totalPrice').text(bookingInfo.total_price);
    $('#status').text(bookingInfo.status);

    // Clear any existing buttons in the modal footer
    $('#modalFooter').empty();

    // Append approve and reject buttons to the modal footer if the booking is pending
    if (bookingInfo.status === 'Pending') {
        $('#modalFooter').append('<button type="button" class="btn btn-success" id="approveBtn">Approve</button>' +
            '<button type="button" class="btn btn-danger" id="rejectBtn">Reject</button>');

        // Add click event listeners to the approve and reject buttons
        $('#approveBtn').click(function() {
            // Handle approve action
            updateBookingStatus(bookingInfo.booking_id, 'approve');
        });

        $('#rejectBtn').click(function() {
            // Handle reject action
            updateBookingStatusReject(bookingInfo.booking_id, 'reject');
        });
    } else if (bookingInfo.status === 'Approved') {
        // Append check-in button to the modal footer if the booking is approved
        $('#modalFooter').append('<button type="button" class="btn btn-primary" id="checkinBtn">Check-in</button>');

        // Add click event listener to the check-in button
        $('#checkinBtn').click(function() {
    // Handle check-in action
    checkInBooking(bookingInfo.booking_id);
});
} else if (bookingInfo.status === 'Ongoing') {
    // Append mark as done button to the modal footer if the booking is checked in
    $('#modalFooter').append('<button type="button" class="btn btn-info" id="markAsDoneBtn">Mark as Done</button>');

    // Add click event listener to the mark as done button
    $('#markAsDoneBtn').click(function() {
        // Handle mark as done action
        markBookingAsDone(bookingInfo.booking_id);
    });


    }
});

                        cell.append(badge);
                    });
                }
                row.append(cell);
                dateCounter++;
            } else {
                row.append($('<td>'));
            }

            if (i % 7 === 6) { // end of the row
                calendarTable.append(row);
                row = $('<tr>');
            }
        }

        calendarDiv.html('').append(calendarTable);

        var monthName = getMonthName(month);
        var header = $('<div>').addClass('calendar-header').append(
            $('<button>').addClass('btn btn-secondary').text('❮').click(prevMonth),
            $('<span>').text(monthName + ' ' + year), // Include the year
            $('<button>').addClass('btn btn-secondary').text('❯').click(nextMonth)
        );
        calendarDiv.prepend(header);
    }

    function prevMonth() {
        var currentYear = parseInt($('.calendar-header span').text().split(' ')[1]);
        var currentMonth = getMonthIndex($('.calendar-header span').text().split(' ')[0]);
        currentMonth -= 1;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear -= 1;
        }
        renderCalendarForMonthYear(currentYear, currentMonth, bookedData);
    }

    function nextMonth() {
        var currentYear = parseInt($('.calendar-header span').text().split(' ')[1]);
        var currentMonth = getMonthIndex($('.calendar-header span').text().split(' ')[0]);
        currentMonth += 1;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear += 1;
        }
        renderCalendarForMonthYear(currentYear, currentMonth, bookedData);
    }

    function renderCalendar() {
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth();

        // Fetch booked dates using AJAX
        $.ajax({
            url: '../php/fetchbooking.php',
            method: 'GET',
            success: function(response) {
                bookedData = JSON.parse(response); // Assign fetched data to the global variable bookedData
                renderCalendarForMonthYear(currentYear, currentMonth, bookedData);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function updateBookingStatus(bookingId, action) {
        // Trigger SweetAlert2 confirmation modal
        let confirmationText = action === 'approve' ? 'approve' : 'reject';
        Swal.fire({
            title: `Are you sure?`,
            text: `Do you want to ${confirmationText} this booking?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${confirmationText} it!`
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to approve or reject the booking
                $.ajax({
                    url: '../php/approve-booking.php',
                    method: 'POST',
                    data: { bookingId: bookingId, action: action },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                // Reload the page or perform any other action
                                location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                timer: 2000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.',
                            icon: 'error',
                            timer: 2000
                        });
                    }
                });
            }
        });
    }
    function updateBookingStatusReject(bookingId, action) {
        // Trigger SweetAlert2 confirmation modal
        let confirmationText = action === 'approve' ? 'approve' : 'reject';
        Swal.fire({
            title: `Are you sure?`,
            text: `Do you want to Reject this booking?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, Reject it!`
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to approve or reject the booking
                $.ajax({
                    url: '../php/reject-booking.php',
                    method: 'POST',
                    data: { bookingId: bookingId, action: action },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                // Reload the page or perform any other action
                                location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                timer: 2000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.',
                            icon: 'error',
                            timer: 2000
                        });
                    }
                });
            }
        });
    }
    function checkInBooking(bookingId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to check in this booking?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, check in!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to check in the booking
            $.ajax({
                url: '../php/checkin-day.php',
                method: 'POST',
                data: { bookingId: bookingId }, // Pass the bookingId parameter
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            // Reload the page or perform any other action
                            location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            timer: 2000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                        timer: 2000
                    });
                }
            });
        }
    });
}
function markBookingAsDone(bookingId) {
    // Trigger SweetAlert2 confirmation modal
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to mark this booking as done?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, mark it as done!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to mark the booking as done
            $.ajax({
                url: '../php/markdone.php',
                method: 'POST',
                data: { bookingId: bookingId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            // Reload the page or perform any other action
                            location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            timer: 2000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                        timer: 2000
                    });
                }
            });
        }
    });
}



    function getMonthName(monthIndex) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthIndex];
    }

    function getMonthIndex(monthName) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months.indexOf(monthName);
    }

    function getFormattedDate(year, month, day) {
        var monthStr = ('0' + (month + 1)).slice(-2); // Adding 1 because month is zero-based
        var dayStr = ('0' + day).slice(-2);
        return year + '-' + monthStr + '-' + dayStr;
    }
});


</script>
<script>document.getElementById("sidebarCollapse").addEventListener("click", function() {
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
