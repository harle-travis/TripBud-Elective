<?php
// Include database connection and any necessary functions
include('../db/db.php');

// Check if room ID is provided in the URL
if (isset($_GET['room_id'])) {
    // Retrieve room details based on the provided room ID
    $room_id = $_GET['room_id'];
    $sql = "SELECT * FROM rooms WHERE room_id = $room_id";
    $result = $conn->query($sql);

    // Check if room exists
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
    } else {
        // Redirect or display an error message if room doesn't exist
        header("Location: rooms.php");
        exit;
    }
} else {
    // Redirect or display an error message if room ID is not provided
    header("Location: rooms.php");
    exit;
}
?>
<?php
// Define an array of possible amenities
$possibleAmenities = array(
    "Wifi",
    "Aircon",
    "Television",
    "Refrigerator",
    "Board Games"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <title>Edit Room</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
            border-radius: 5px;
        }

        .btn-dark:hover {
            background-color: #23272b;
            border-color: #1d2124;
        }

        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .requirements {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .room-form {
    background-color: #f8f9fa;
    padding: 30px 15px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
    </style>
</head>

<body>
<div class="container mt-5 shadow-none">
    <h2 class="mt-2 mb-4 text-center">Edit Room Details</h2>
    <form id="updateRoomForm" class="room-form" enctype="multipart/form-data">

        <input type="hidden" name="room_id" id="update_room_id" value="<?php echo $room_id; ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="room_name" class="form-label">Room Name</label>
                <input type="text" class="form-control mb-3" required name="room_name" id="room_name" value="<?php echo $room['room_name']; ?>">
                <div class="error" id="room_name_error"></div>
            </div>
            <div class="col-md-6">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control mb-3" required name="price" id="price" value="<?php echo $room['price']; ?>">
                <div class="error" id="price_error"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="room_size" class="form-label">Room Size</label>
                <input type="text" class="form-control mb-3" required name="room_size" id="room_size" value="<?php echo isset($room['room_size']) ? $room['room_size'] : ''; ?>">
                <div class="error" id="room_size_error"></div>
            </div>
            <div class="col-md-4">
                <label for="num_rooms" class="form-label">Number of Rooms</label>
                <input type="number" class="form-control mb-3" required name="num_rooms" id="num_rooms" value="<?php echo isset($room['num_rooms']) ? $room['num_rooms'] : ''; ?>">
                <div class="error" id="num_rooms_error"></div>
            </div>
            <div class="col-md-4">
                <label for="num_bathrooms" class="form-label">Number of Bathrooms</label>
                <input type="number" class="form-control mb-3" required name="num_bathrooms" id="num_bathrooms" value="<?php echo isset($room['num_bathrooms']) ? $room['num_bathrooms'] : ''; ?>">
                <div class="error" id="num_bathrooms_error"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="image_path" class="form-label">Room Image</label>
                <!-- Display current image associated with the room -->
                <img src="<?php echo $room['image_path']; ?>" alt="Current Room Image" class="img-fluid mb-3">
                <input type="file" class="form-control mb-3"  name="image_path" id="image_path">
                <div class="error" id="image_path_error"></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Amenities</label>
                <div class="d-flex flex-wrap">
                    <?php foreach ($possibleAmenities as $amenity) : ?>
                        <?php
                        // Check if the current amenity exists in the room's amenities
                        $isChecked = isset($room['amenities']) && in_array($amenity, explode(",", $room['amenities']));
                        ?>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input" type="checkbox" name="amenities[]" id="<?php echo strtolower(str_replace(' ', '_', $amenity)); ?>" value="<?php echo $amenity; ?>" <?php if ($isChecked) echo "checked"; ?>>
                            <label class="form-check-label" for="<?php echo strtolower(str_replace(' ', '_', $amenity)); ?>"><?php echo $amenity; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-3 text-center">
                <button type="button" class="btn btn-warning me-2" onclick="window.location.href='rooms.php'">Cancel</button>
                <button type="submit" class="btn btn-dark">Update</button>
            </div>
        </div>

    </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
    $(document).ready(function() {
        // Submit form data via AJAX
        $('#updateRoomForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Display confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to update this room details.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Serialize form data
                    var formData = new FormData(this);

                    // AJAX call to edit-room-process.php
                    $.ajax({
                        url: '../php/edit-room-process.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            // Handle success response
                            Swal.fire({
                                icon: 'success',
                                title: 'Room Updated!',
                                text: 'Room details have been updated successfully.',
                                showConfirmButton: false,
                                timer: 1500 // Close alert after 1.5 seconds
                            }).then(function() {
                                window.location.href = '../admin/rooms.php?success=room_updated';
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while updating room details.'
                            });
                        }
                    });
                }
            });
        });
    });
</script>


</body>

</html>