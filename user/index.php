<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        box-shadow: 1px 2px 3px 0px white;
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
      height: 500px;
      object-fit: fill;
      
    }

    .swiper-container-slide-img {
      object-fit: cover;
      z-index: -1;
    position:relative;
    }

    .custom-bg {
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

  </style>
    <title>TripBud Home</title>
</head>
<body class="bg-light">
<?php
  include('user-nav.php');
  ?>
  <div class="container-fluid px-lg-4 mt-4">
  
    <div class="swiper swiper-container">
      
    
      <div class="swiper-wrapper">
      
        <div class="swiper-slide">
        <div class="content h-font">TripBud</div>
        <div class="contentText">Let’s start your journey with us, your dream will come true</div>
        <?php if (isset($_SESSION['user_id'])) : ?>
          <a class="contentButton nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'rooms.php') echo 'active'; ?>" href="rooms.php" id="rooms-link">
          View Destinations!
        </a>
        <?php else : ?>
        <!-- User is not logged in, show login and register buttons -->
        <button class="contentButton"type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">
          Discover Now!
        </button>
        <?php endif; ?>
        
          <img src="../img/banner_bg 1.png" alt="image1" class="w-100 d-block" />
        </div>
      
        
      </div>

    </div>
    
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="../JS/index.js"></script>
</body>
</html>
