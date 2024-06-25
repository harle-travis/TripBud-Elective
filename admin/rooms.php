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
    <title>Room Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
<?php
include('nav.php');
?>
        <div class="col-md-9 mt-5" id="mainContent">
        <div class="container">
            <h2 class="d-flex justify-content-center">Room Data</h2>
            <div class="button-container">
                <button type="button" class="btn btn-primary mb-3 py-2" data-bs-toggle="modal" data-bs-target="#addRoom">
                    + Room
                </button>
                <button id="deleteSelected" class="btn btn-danger mb-3 py-2">
                    Delete Selected Records
                </button>
                <div class="search-container mb-3">
                    <input type="text" id="searchInput" placeholder="Search for rooms...">
                    <button id="searchButton" class="btn btn-primary">Search</button>
                </div>

            </div>
            <div class="table-responsive">
                <table id="roomTable" class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Room ID </th>
                            <th>Room Name</th>
                            <th>Price</th>
                            <th>Room Size</th>
                            <th>Number of Rooms</th>
                            <th>Number of Bathrooms</th>
                            <th>Amenities</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include the database connection
                        include('../db/db.php');

                        // Constants for pagination
                        $records_per_page = isset($_GET['records_per_page']) ? intval($_GET['records_per_page']) : 10;

                        // Get the current page number
                        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $offset = ($page - 1) * $records_per_page;

                        // Fetch room data from the database with pagination
                        $sql = "SELECT * FROM rooms LIMIT $offset, $records_per_page";
                        $result = $conn->query($sql);

                        // Display room data in table rows
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' class='checkbox'></td>";

                                echo "<td>{$row['room_id']}</td>";
                                echo "<td>{$row['room_name']}</td>";
                                echo "<td>{$row['price']}</td>";
                                echo "<td>{$row['room_size']}</td>";
                                echo "<td>{$row['num_rooms']}</td>";
                                echo "<td>{$row['num_bathrooms']}</td>";
                                echo "<td>{$row['amenities']}</td>";
                                echo "<td><img src='{$row['image_path']}' alt='{$row['room_name']}'></td>";
                                echo "<td>";
                                echo "<a href='edit-room.php?room_id=" . $row['room_id'] . "' class='btn btn-primary'>Edit</a>";

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No rooms found</td></tr>";
                        }

                        // Close database connection
                        ?>

                    </tbody>
                </table>
                <div class="form-group selectPage">
                    <label for="recordsPerPage">Records Per Page: </label>

                    <select class="form-control page" id="recordsPerPage" onchange="changeRecordsPerPage(this.value)">
                        <option value="5" <?php if ($records_per_page == 5) echo "selected"; ?>>5</option>
                        <option value="10" <?php if ($records_per_page == 10) echo "selected"; ?>>10</option>
                        <option value="20" <?php if ($records_per_page == 20) echo "selected"; ?>>20</option>
                        <option value="50" <?php if ($records_per_page == 50) echo "selected"; ?>>50</option>
                    </select>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    <?php
                    // Calculate total number of pages
                    $sql = "SELECT COUNT(*) AS total FROM rooms";
                    $result = $conn->query($sql);
                    if ($result === false) {
                        echo "Error executing query: " . $conn->error;
                    } else {
                        $total_records = $result->fetch_assoc()['total'];
                        $total_pages = ceil($total_records / $records_per_page);

                        // Get current page number
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                        // Display previous button
                        echo "<ul class='pagination'>";
                        if ($current_page > 1) {
                            echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page - 1) . "&records_per_page=$records_per_page'>Previous</a></li>";
                        }

                        // Display pagination links
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($current_page == $i) ? "active" : "";
                            echo "<li class='page-item $active'><a class='page-link' href='?page=$i&records_per_page=$records_per_page'>$i</a></li>";
                        }

                        // Display next button
                        if ($current_page < $total_pages) {
                            echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page + 1) . "&records_per_page=$records_per_page'>Next</a></li>";
                        }
                        echo "</ul>";
                    }
                    ?>
                </div>



            </div>
        </div>

        <!-- ADD NEW ROOM MODAL !! -->
        <div class="modal fade" id="addRoom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add new Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" novalidate id="roomForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="room_name" class="form-label">Room Name</label>
                                    <input type="text" class="form-control mb-3" required name="room_name" id="room_name">
                                    <div class="error" id="room_name_error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control mb-3" required name="price" id="price">
                                    <div class="error" id="price_error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="room_size" class="form-label">Room Size</label>
                                    <input type="text" class="form-control mb-3" required name="room_size" id="room_size">
                                    <div class="error" id="room_size_error"></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_rooms" class="form-label">Number of Rooms</label>
                                    <input type="number" class="form-control mb-3" required name="num_rooms" id="num_rooms">
                                    <div class="error" id="num_rooms_error"></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_bathrooms" class="form-label">Number of Bathrooms</label>
                                    <input type="number" class="form-control mb-3" required name="num_bathrooms" id="num_bathrooms">
                                    <div class="error" id="num_bathrooms_error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="image_path" class="form-label">Room Image</label>
                                    <input type="file" class="form-control mb-3" required name="image_path" id="image_path">
                                    <div class="error" id="image_path_error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Amenities</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="wifi" value="Wifi">
                                            <label class="form-check-label" for="wifi">Wifi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="aircon" value="Aircon">
                                            <label class="form-check-label" for="aircon">Aircon</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="tv" value="Television">
                                            <label class="form-check-label" for="tv">Television</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="refrigerator" value="Refrigerator">
                                            <label class="form-check-label" for="refrigerator">Refrigerator</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="board_games" value="Board Games">
                                            <label class="form-check-label" for="board_games">Board Games</label>
                                        </div>
                                        <!-- Add more amenities checkboxes as needed -->
                                    </div>
                                    <div class="error" id="amenities_error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-dark">
                                        Insert
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- RESULT MOPDAL !! -->


        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="updateRoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateRoomModalLabel">Update Room Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" novalidate id="updateRoomForm">
                            <input type="hidden" name="room_id" id="update_room_id">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="room_name" class="form-label">Room Name</label>
                                    <input type="text" class="form-control mb-3" required name="room_name" id="room_name">
                                    <div class="error" id="room_name_error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control mb-3" required name="price" id="price">
                                    <div class="error" id="price_error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="room_size" class="form-label">Room Size</label>
                                    <input type="text" class="form-control mb-3" required name="room_size" id="room_size">
                                    <div class="error" id="room_size_error"></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_rooms" class="form-label">Number of Rooms</label>
                                    <input type="number" class="form-control mb-3" required name="num_rooms" id="num_rooms">
                                    <div class="error" id="num_rooms_error"></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_bathrooms" class="form-label">Number of Bathrooms</label>
                                    <input type="number" class="form-control mb-3" required name="num_bathrooms" id="num_bathrooms">
                                    <div class="error" id="num_bathrooms_error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="image_path" class="form-label">Room Image</label>
                                    <input type="file" class="form-control mb-3" required name="image_path" id="image_path">
                                    <div class="error" id="image_path_error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Amenities</label>
                                    <div>
                                        <!-- You can set the checked attribute dynamically based on the existing amenities -->
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="wifi" value="Wifi" <?php if (in_array("Wifi", explode(",", $row['amenities']))) echo "checked"; ?>>
                                            <label class="form-check-label" for="wifi">Wifi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" id="aircon" value="Aircon" <?php if (in_array("Aircon", explode(",", $row['amenities']))) echo "checked"; ?>>
                                            <label class="form-check-label" for="aircon">Aircon</label>
                                        </div>
                                        <!-- Similarly, set the checked attribute for other amenities -->
                                    </div>
                                    <div class="error" id="amenities_error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="btn">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateRoomBtn">Update Room</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="../JS/create-room.js"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the "Select All" checkbox
            const selectAllCheckbox = document.getElementById("selectAll");

            // Get all individual checkboxes
            const checkboxes = document.querySelectorAll(".checkbox");

            // Function to handle checkbox change event
            function handleCheckboxChange(event) {
                // Initialize an empty array to store checked room IDs
                const checkedRoomIds = [];

                // Loop through all individual checkboxes to record checked room IDs
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        // Get the corresponding room ID from the table row
                        const roomId = checkbox.parentElement.nextElementSibling.textContent;
                        checkedRoomIds.push(roomId);
                    }
                });

                // Update the "Select All" checkbox status based on the number of checked checkboxes
                selectAllCheckbox.checked = checkboxes.length === checkedRoomIds.length;

                // Log the array of checked room IDs (you can send this data to the server for further processing)
                console.log("Checked Room IDs:", checkedRoomIds);
            }

            // Add event listener for "Select All" checkbox change event
            selectAllCheckbox.addEventListener("change", function(event) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = event.target.checked;
                });
                // Call handleCheckboxChange to update checkedRoomIds array and "Select All" checkbox status
                handleCheckboxChange(event);
            });

            // Add event listener for individual checkbox change event
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", handleCheckboxChange);
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to handle checkbox change event
            function handleCheckboxChange(event) {
                updateDeleteButtonState();
            }

            // Function to handle "Select All" checkbox change event
            function handleSelectAllChange(event) {
                const selectAllCheckbox = event.target;
                const checkboxes = document.querySelectorAll(".checkbox");
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateDeleteButtonState();
            }

            // Function to update the state of the "Delete Selected Records" button
            function updateDeleteButtonState() {
                const checkboxes = document.querySelectorAll(".checkbox");
                const isAnyCheckboxChecked = Array.from(checkboxes).some(function(checkbox) {
                    return checkbox.checked;
                });
                const deleteSelectedButton = document.getElementById("deleteSelected");
                deleteSelectedButton.disabled = !isAnyCheckboxChecked;
            }

            // Function to handle deletion of selected records
            function deleteSelectedRecords() {
                const checkboxes = document.querySelectorAll(".checkbox");
                const isAnyCheckboxChecked = Array.from(checkboxes).some(function(checkbox) {
                    return checkbox.checked;
                });

                if (!isAnyCheckboxChecked) {
                    alert("Please select records to delete.");
                    return;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to delete the selected records.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete them!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Prepare selected room IDs
                        const selectedRoomIds = [];
                        checkboxes.forEach(function(checkbox) {
                            if (checkbox.checked) {
                                // Push the room ID (stored as text in the next sibling of the checkbox)
                                selectedRoomIds.push(checkbox.parentElement.nextElementSibling.textContent);
                            }
                        });

                        // Send request to delete.php with selected room IDs
                        fetch('../php/delete-room.php', {
                                method: 'POST',
                                body: JSON.stringify({
                                    room_ids: selectedRoomIds
                                }),
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The selected records have been deleted.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "An error occurred while deleting records.",
                                        icon: "error"
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting records.",
                                    icon: "error"
                                });
                            });
                    }
                });
            }

            // Add event listener for "Delete Selected Records" button click event
            const deleteSelectedButton = document.getElementById("deleteSelected");
            deleteSelectedButton.addEventListener("click", deleteSelectedRecords);

            // Add event listener for individual checkbox change event
            const checkboxes = document.querySelectorAll(".checkbox");
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", handleCheckboxChange);
            });

            // Add event listener for "Select All" checkbox change event
            const selectAllCheckbox = document.getElementById("selectAll");
            selectAllCheckbox.addEventListener("change", handleSelectAllChange);

            // Call the function initially to update button state
            updateDeleteButtonState();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const searchButton = document.getElementById("searchButton");
            const tableBody = document.querySelector("#roomTable tbody");

            searchButton.addEventListener("click", function() {
                const searchText = searchInput.value.trim();
                if (searchText !== "") {
                    // Send search query to server
                    fetch(`../php/search-process.php?query=${searchText}`)
                        .then(response => response.json())
                        .then(data => {
                            // Clear table
                            tableBody.innerHTML = "";
                            // Populate table with search results
                            data.forEach(room => {
                                const row = `
                            <tr>
                                <td><input type='checkbox' class='checkbox'></td>
                                <td>${room.room_id}</td>
                                <td>${room.room_name}</td>
                                <td>${room.price}</td>
                                <td>${room.room_size}</td>
                                <td>${room.num_rooms}</td>
                                <td>${room.num_bathrooms}</td>
                                <td>${room.amenities}</td>
                                <td><img src='${room.image_path}' alt='${room.room_name}'></td>
                                <td>
                                    <a href='edit-room.php?room_id=${room.room_id}' class='btn btn-primary'>Edit</a>
                                </td>
                            </tr>
                        `;
                                tableBody.insertAdjacentHTML("beforeend", row);
                            });
                        })
                        .catch(error => console.error("Error:", error));
                }
            });
        });
        document.getElementById("sidebarCollapse").addEventListener("click", function() {
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