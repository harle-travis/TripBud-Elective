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

  <title>Contact us</title></head>
<body>
    <?php
  include('user-nav.php');
  ?>
<section id="contactus">
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Contact us</h2>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3868.275231501857!2d121.13364027407219!3d14.178651187269894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63862f343bdd%3A0x27b21f8ee9b7395d!2sNational%20University%20Laguna!5e0!3m2!1sen!2sph!4v1719261271072!5m2!1sen!2sph" width="600" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>
        <div class="col-lg-4 col-md-4">
          <div class="bg-white p-4 rounded">
            <h5> Contact us </h5>
            <a class="d-inline-block mb-2 text-decoration-none text-dark">
              <i class="bi bi-telephone-fill"></i> 0912 345 6789
            </a>
            <br>
            <a class="d-inline-block  text-decoration-none text-dark">
              <i class="bi bi-telephone-fill"></i> 0912 345 6789
            </a>
          </div>
          <div class="bg-white p-4 rounded">
            <h5> Follow us </h5>
            <a href="https://www.facebook.com/NULagunaPH" class="d-inline-block mb-3">
              <span class="badge bg-light text-dark fs-6 p-2">
                <i class="bi bi-facebook"></i> National University - Laguna
              </span>
            </a>
            <br>
            <a href="#" class="d-inline-block mb-3">
              <span class="badge bg-light text-dark fs-6 p-2">
                <i class="bi bi-envelope-fill"></i></i> admissions@nu-laguna.edu.ph
              </span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="../JS/index.js"></script>

</body>
</html>