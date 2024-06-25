<?php
include_once "../db/db.php";

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

$booked_dates = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Convert check-in and check-out time to AM/PM format
        $checkin_time = date("h:i A", strtotime($row['checkin_time']));
        $checkout_time = date("h:i A", strtotime($row['checkout_time']));
        
        $booked_dates[] = [
            'booking_id' => $row['booking_id'], // Include booking ID
            'checkin_date' => $row['checkin_date'],
            'checkout_date' => $row['checkout_date'],
            'checkin_time' => $checkin_time, // Updated check-in time
            'checkout_time' => $checkout_time, // Updated check-out time
            'num_adults' => $row['num_adults'],
            'num_children' => $row['num_children'],
            'total_price' => $row['total_price'],
            'status' => $row['status']
        ];
    }
}

$conn->close();

echo json_encode($booked_dates);
?>
