<?php
// Include the database connection
include('../db/db.php');

// Check if room ID is provided in the request
if(isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    // Query to fetch room details from the database
    $sql = "SELECT * FROM rooms WHERE room_id = $room_id";
    $result = $conn->query($sql);

    // Check if room details were found
    if ($result->num_rows > 0) {
        // Fetch room details as an associative array
        $row = $result->fetch_assoc();

        // Convert room details to JSON format and echo the response
        echo json_encode($row);
    } else {
        // No room found with the provided ID
        echo json_encode(array('error' => 'Room not found'));
    }
} else {
    // Room ID not provided in the request
    echo json_encode(array('error' => 'Room ID not provided'));
}

// Close database connection
$conn->close();
?>
