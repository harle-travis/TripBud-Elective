<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Food to Try</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }
    .content {
      -webkit-text-stroke-width: 0.2px;
            -webkit-text-stroke-color: white;
      top: 80px;
      left: 41.5%;
      font-size: 60px;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;
    z-index: 1;
    position:absolute;
    }
    .contentText {

      top: 180px;
      left: 29%;
      font-size: 20px;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;
    z-index: 1;
    position:absolute;
    }
    .contentButton{
      padding: 14px 40px;
      top: 250px;
      left: 42.5%;
      margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
        z-index: 1;
        position:absolute;
        background-color: #FF5403;
        border-radius: 6px;
        box-shadow: 1px 2px 3px 0px #000000;
    }
    .left{
      margin-left: 40px;
    }
    .left2{
      margin-left: 235px;
    }
    .right{
      margin-right: 60px;
    }

    .h-font {
      font-family: 'Merienda', cursive;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .swiper-container {
      width: 100%;
      height: 350px;
      object-fit: fill
    }

    .swiper-container-slide-img {
      object-fit: cover;
    }

    .btn.custom-bg {
      background-color: #2ec1ac;
    }

    .custom-bg:hover {
      background-color: #2ec12e;
    }

    .availability-form {
      margin-top: -50px;
      z-index: 2;
      position: relative;
    }

    .error-message {
      color: red;
    }
    .modal-backdrop {
    display: none;
}

  </style>

</head>

<body>
  <?php
  include('user-nav.php');
  ?>
  <!---rooms -->
  <section id="rooms">
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Food to Try</h2>

    <div class="container">
      <div class="row">
      <form action="" method="GET">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search by name or description.." name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
    </div>
</form>


        <div class="row">
          <?php
          include('../db/db.php');

          // Retrieve rooms data from the database
          $recordsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 6;
          $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
          $offset = ($currentPage - 1) * $recordsPerPage;

          // Initialize search query
          $searchQuery = "";

          // Check if search term is provided
          if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $search = $_GET['search'];
            // Add search criteria to the SQL query
            $searchQuery = " WHERE food_name LIKE '%$search%' OR description LIKE '%$search%'";
          }

          // Retrieve rooms data from the database with pagination and search
          $sql = "SELECT * FROM food $searchQuery LIMIT $recordsPerPage OFFSET $offset";
          $result = $conn->query($sql);


          if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
          ?>
              <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto; ">
                  <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Room">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $row['food_name']; ?></h5>
                    <div class="features mb-4">
                      <h6 class="mb-2">Description:</h6>
                      <span >
                        <?php echo $row['description']; ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Booking Modal for Room <?php echo $row['room_name']; ?> -->
              <div class="modal fade" id="bookingModal_<?php echo $row['room_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <form id="bookingForm_<?php echo $row['room_id']; ?>" action="../php/booking-process.php">
                      <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                          <i class="bi bi-calendar3-fill fs-3 me-2"></i> Booking Form for <?php echo $row['room_name']; ?> - ₱<?php echo $row['price']; ?>/8 Hours
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">
                          <div class="row">
                            <input type="hidden" id="room_id" name="room_id" value="<?php echo $row['room_id']; ?>">

                            <div class="col-md-6 ps-0 mb-3">
                              <label for="checkin_<?php echo $row['room_id']; ?>" class="form-label">Check-in Date</label>
                              <input type="date" class="form-control" id="checkin_<?php echo $row['room_id']; ?>" name="checkin_date" min="<?php echo date('Y-m-d'); ?>">
                              <span id="error-checkin_<?php echo $row['room_id']; ?>" class="error-message"></span>

                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                              <label for="checkout_<?php echo $row['room_id']; ?>" class="form-label">Check-out Date</label>
                              <input type="date" class="form-control" id="checkout_<?php echo $row['room_id']; ?>" name="checkout_date" min="<?php echo date('Y-m-d'); ?>">
                              <span id="error-checkout_<?php echo $row['room_id']; ?>" class="error-message"></span>

                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                              <label for="checkin_time_<?php echo $row['room_id']; ?>" class="form-label">Check-in Time</label>
                              <input type="time" class="form-control" id="checkin_time_<?php echo $row['room_id']; ?>" name="checkin_time">
                              <span id="error-checkin-time_<?php echo $row['room_id']; ?>" class="error-message"></span>

                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                              <label for="checkout_time_<?php echo $row['room_id']; ?>" class="form-label">Check-out Time</label>
                              <input type="time" class="form-control" id="checkout_time_<?php echo $row['room_id']; ?>" name="checkout_time">
                              <span id="error-checkout-time_<?php echo $row['room_id']; ?>" class="error-message"></span>

                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                              <label for="num_adults_<?php echo $row['room_id']; ?>" class="form-label">Number of Adults</label>
                              <input type="number" class="form-control" id="num_adults_<?php echo $row['room_id']; ?>" name="num_adults" min="1">
                              <span id="error-num-adults_<?php echo $row['room_id']; ?>" class="error-message"></span>

                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                              <label for="num_children_<?php echo $row['room_id']; ?>" class="form-label">Number of Children</label>
                              <input type="number" class="form-control" id="num_children_<?php echo $row['room_id']; ?>" name="num_children" min="0">
                            </div>
                            <div class="col-md-12 ps-0 mb-3">
                              <label for="total_price_<?php echo $row['room_id']; ?>" class="form-label">Total Price</label>
                              <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="total_price_<?php echo $row['room_id']; ?>" name="total_price" readonly>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="return validateForm('<?php echo $row['room_id']; ?>')">Book Now</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "0 results";
          }
          // Close the database connection
          $conn->close();
          ?>
        </div>

      </div>
      <!-- Booking result Modal  -->
      <div class="modal fade" id="bookingResultModal" tabindex="-1" aria-labelledby="bookingResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="bookingResultModalLabel">Booking Result</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="bookingResultBody">
              <!-- Result will be displayed here -->
            </div>
          </div>
        </div>
      </div>
    

        <div class="col-lg-8 text-end">
  <div class="btn-group" role="group" aria-label="Pagination">
    <?php
    include('../db/db.php');

    // Get current page from URL parameter
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    // Check if there is a search term
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Count total records based on search
    if (!empty($searchTerm)) {
        $sql = "SELECT COUNT(*) AS total FROM rooms WHERE room_name LIKE '%$searchTerm%'";
    } else {
        $sql = "SELECT COUNT(*) AS total FROM rooms";
    }

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalRecords = $row['total'];

    // Calculate total pages
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Calculate range of pages to display
    $startPage = max(1, $currentPage - 1);
    $endPage = min($totalPages, $startPage + 2);

    // Generate previous button if not on the first page
    if ($currentPage > 1) {
      $prevPage = max(1, $currentPage - 1);
      echo '<a href="?page=' . $prevPage . '&per_page=' . $recordsPerPage . '&search=' . $searchTerm . '" class="btn btn-sm btn-outline-dark">Previous</a>';
    }

    // Display pagination links
    for ($i = $startPage; $i <= $endPage; $i++) {
      $activeClass = ($i == $currentPage) ? 'active' : ''; // Add 'active' class for the current page
      echo '<a href="?page=' . $i . '&per_page=' . $recordsPerPage . '&search=' . $searchTerm . '" class="btn btn-sm btn-outline-dark ' . $activeClass . '">' . $i . '</a>';
    }

    // Generate next button if not on the last page
    if ($currentPage < $totalPages) {
      $nextPage = min($totalPages, $currentPage + 1);
      echo '<a href="?page=' . $nextPage . '&per_page=' . $recordsPerPage . '&search=' . $searchTerm . '" class="btn btn-sm btn-outline-dark">Next</a>';
    }
    ?>
  </div>
</div>




  </section>



</body>

</html>