<?php
include '../db/db.php'; // Include db.php for database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo "Please enter a valid email address.";
        exit; // Exit the script if email is invalid
    }

    // Validate password
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password)) {
        http_response_code(400); // Bad Request
        echo "Password must contain at least 8 characters, including 1 uppercase letter, 1 lowercase letter, and 1 digit.";
        exit; // Exit the script if password is invalid
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM admin WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_query);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $result = $check_email_stmt->get_result();

    if ($result->num_rows > 0) {
        http_response_code(409); // Conflict
        echo "Email already exists.";
        exit; // Exit the script if email already exists
    }

    // Prepare SQL statement to insert data into the admin table
    $sql = "INSERT INTO admin (name, email, password) VALUES (?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Admin registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statements and connection
    $stmt->close();
    $check_email_stmt->close();
    $conn->close();
}
?>
