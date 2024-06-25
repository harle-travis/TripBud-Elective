<?php
// Start the session
@session_start();

include('../db/db.php');

// Check if the user is logged in and the user ID is set in the session
if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Proceed with fetching notifications
    // Prepare the SQL statement
    $sql = "SELECT id, message, is_read FROM notifications WHERE user_id = ? ORDER BY ID DESC";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param('i', $userId); // Assuming user_id is an integer
        $stmt->execute();

        // Bind the result variables
        $stmt->bind_result($id, $message, $is_read);

        // Fetch the notifications
        $notifications = array();
        while ($stmt->fetch()) {
            // Check if the notification is new
            $isNew = ($is_read == 0) ? true : false;

            // Output the notification message
            echo "<a class='dropdown-item" . ($isNew ? " new-notification" : "") . "' href='#' data-notification-id='$id'>$message</a>";

            // If the notification is new, mark it as read
            if ($isNew) {
                // Store the notification ID for updating
                $notificationIds[] = $id;
            }
        }

        // Close the statement and free the result set
        $stmt->close();

        // Update notifications as read
        if (!empty($notificationIds)) {
            $updateSql = "UPDATE notifications SET is_read = 1 WHERE id IN (" . implode(',', $notificationIds) . ")";
            if ($conn->query($updateSql) === FALSE) {
                // Handle the case where the update query fails
                echo "Error updating notifications: " . $conn->error;
            }
        }
    } else {
        // Handle the case where the statement preparation fails
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where the user is not logged in
    echo "User is not logged in.";
}

?>
