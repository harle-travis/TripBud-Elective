<?php
include('../db/db.php');

// Initialize response array
$response = array();

// Check if bookingId is set and not empty
if(isset($_POST['bookingId']) && !empty($_POST['bookingId'])) {
    $bookingId = $_POST['bookingId'];

    // Update the status to 'Done' in the database
    $sql = "UPDATE bookings SET status = 'Completed' WHERE booking_id = $bookingId";
    if ($conn->query($sql) === TRUE) {
        // Return success message
        $response['success'] = true;
        $response['message'] = 'Booking marked as done successfully!';
    } else {
        // Return error message
        $response['success'] = false;
        $response['message'] = 'Error updating booking status: ' . $conn->error;
    }
} else {
    // Return error message if bookingId is not provided
    $response['success'] = false;
    $response['message'] = 'Invalid request!';
}

// Close database connection
$conn->close();

// Output JSON response
echo json_encode($response);
?>
