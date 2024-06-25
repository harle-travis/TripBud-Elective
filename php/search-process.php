<?php
// Include the database connection
require_once('../db/db.php');

// Initialize response array
$response = array();

// Check if the search query parameter is set
if (isset($_GET['query'])) {
    // Sanitize the search query
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

    // Perform database query to search for rooms
    $sql = "SELECT * FROM rooms WHERE room_name LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch matching room data
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    }
}

// Close database connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
