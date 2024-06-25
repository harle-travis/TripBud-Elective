<?php
include('../db/db.php');

// Retrieve form data
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Include the database configuration file

try {
    // Prepare and execute the SQL statement to fetch user data by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password_hash'])) { // Compare hashed password
            // Start the session
            session_start();

            // Store user data in session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name']; // Store the user's name in the session

            // Return success response
            $login_response = ['status' => 'success'];
        } else {
            // Return error response
            $login_response = ['status' => 'error', 'message' => 'Invalid email or password.'];
        }
    } else {
        // Return error response
        $login_response = ['status' => 'error', 'message' => 'No user found with this email.'];
    }
} catch (Exception $e) {
    // Return error response with detailed error information
    $login_response = ['status' => 'error', 'message' => 'Error: ' . $e->getMessage()];
}

// Close the database connection
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($login_response);
?>
