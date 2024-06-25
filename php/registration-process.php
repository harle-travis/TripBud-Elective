<?php
// Include database connection details
include '../db/db.php';

// Initialize response array
$response = array();

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set before accessing them
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : ''; // Don't escape password field
    $phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
    $birthdate = isset($_POST['birthdate']) ? $conn->real_escape_string($_POST['birthdate']) : '';
    $address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
    $postal_code = isset($_POST['postalcode']) ? $conn->real_escape_string($_POST['postalcode']) : '';

    // Check if email already exists in the database
    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email_query);
    if ($result->num_rows > 0) {
        // Email already exists, return error response
        $response['success'] = false;
        $response['message'] = "Error: Email already exists. Please choose a different email address.";
        echo json_encode($response);
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // File upload handling for ID image
    $id_image = ""; // Placeholder for image path
    if(isset($_FILES['id']) && $_FILES['id']['error'] == 0){
        $target_dir = "../uploads/"; // Specify the directory where you want to store the uploaded files
        $target_file = $target_dir . basename($_FILES['id']['name']);
        
        // Check if file type is allowed (optional)
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_types)) {
            $response['success'] = false;
            $response['message'] = "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
            echo json_encode($response);
            exit;
        }
        
        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['id']['tmp_name'], $target_file)) {
            $id_image = $target_file;
        } else {
            $response['success'] = false;
            $response['message'] = "Error uploading file.";
            echo json_encode($response);
            exit;
        }
    }

    // Insert user data into database
    $sql = "INSERT INTO users (name, email, password_hash, phone, birthdate, address, postal_code, id_image)
            VALUES ('$name', '$email', '$password_hash', '$phone', '$birthdate', '$address', '$postal_code', '$id_image')";

    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Registration successful!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();

// Return JSON response
echo json_encode($response);
?>
