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

    .about{
      position: relative;
      width:100%;
      height:100vh;
      display: inline-block;
      justify-content: center;
      align-items: center;
      font-size:100px;
     
    }
    .about img{
      display: block;
      width:100%;
      height:100vh;
    }
    .description{
      width:100%;
      height:100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size:30px;
      background-color:#445f72;
  
      
    }
    .description p{
      display: flex;
      color: #fff;
      font-style: italic;
      justify-content: center;
      text-align: center;
      font-family:'Times New Roman', Times, serif;
      margin: 250px;
    }
    .vision-mission {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .vision, .mission {
      width: 45%;
      padding: 20px;
      border: 1px solid #000000;
      border-radius: 20px;
      height: 29vh;
    }

    .vision {
      margin-right: 20px;
    }

    .mission {
      margin-left: 20px;
    }

    .vision h1, .mission h1 {
      margin-top: 5px;
      font-size: 24px;
      text-align: center;
    }

    .vision p, .mission p, .mission li {
      margin-top: 28px;
      font-size: 16px;
      line-height: 1.5;
      text-align: center;
    }

    .mission ul {
      padding-left: 20px;
    }

    .events {
      display: flex;
      justify-content: center;
      margin-top: 35px;
      margin-bottom: 15px;
      

    }
    .eventtitle{
      width:100%;
      display:flex;
      justify-content: center;
      font-size: 30px;
      text-align: center;
      font-style: italic;
      font-weight: 500;
    }


    .eventimage{
      text-align: center;
      width: 50px;
      height: 50px;
 
 
        }

        .gallery {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.gallery-item {
    padding: 35px;
    text-align: center;
}

img {
    max-width: 100%;
    height: auto;
}



.qcontainer {
  display: flex;
  align-items: center;
}

.qtext {
  flex: 1;
  padding: 50px;
}

.qimage {
  flex: 1;
  text-align: right;
}

.qgym {
  max-width: 50%;
  height: auto;
  margin-right: 40px;
  
}



.wcontainer {
  display: flex;
  align-items: center;
  flex-direction: row-reverse;
}

.wtext {
  flex: 1;
  padding: 50px;
}

.wimage {
  flex: 1;
  text-align: left;
}

.wgym {
  max-width: 50%;
  height: auto;
  margin-left: 40px;
  margin-bottom: 50px;
}
</style>

  <title>About TripBud</title></head>
<body>
<?php
  include('user-nav.php');
  ?>
<section id="facilities">
    
    <div class="facilities">
    <div class="about">
      <div class="aboutimg">
        <img src="../img/beach_bg_1.jpeg"  alt="">
      </div>
        
      
  </div>
    <div class="description">
      <p>TripBud is a premier travel website dedicated to showcasing the breathtaking destinations of the Philippines. Whether you're dreaming of the pristine beaches of Boracay, the stunning landscapes of Palawan, or the vibrant culture of Cebu, TripBud offers an immersive browsing experience. Discover detailed guides, vibrant photos, and insider tips for each location, making it easy to plan your perfect getaway. Explore the rich tapestry of the Philippines with TripBud, where your next adventure is just a click away.
</p>
  </div>
  
</div>

    <div class="events">
      <div class="eventtitle">
      <p>Gallery</p>
      </div>
</div>

      <div class="gallery">
        <div class="gallery-item">
            <img src="../img/0.jpg" alt="Image 1">
        </div>
        <div class="gallery-item">
            <img src="../img/6.png" alt="Image 2">
        </div>
        <div class="gallery-item">
            <img src="../img/2.jpg" alt="Image 3">
        </div>
        <div class="gallery-item">
            <img src="../img/3.jpg" alt="Image 4">
        </div>
        <div class="gallery-item">
            <img src="../img/4.jpg" alt="Image 5">
        </div>
        <div class="gallery-item">
            <img src="../img/5.jpg" alt="Image 6">
        </div>
    </div>




      </div>


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