<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="./images/category/about-img-1.png" alt="">
         <h3>why choose us?</h3>
         <marquee style="font-size:30px;" behavior="scrool" direction="left" scrollamount="7">If you are looking for a one-stop-shop for all your grocery needs, look no further than our super shop website. We offer a wide range of high-quality products at competitive prices, making it easy to find everything you need in one convenient location. Our online ordering and delivery services are fast, efficient, and reliable, allowing you to shop from the comfort of your own home and have your groceries delivered straight to your doorstep.</marquee>
         <a href="contact.php" class="btn">contact us</a>
      </div>

      <div class="box">
         <img src="./images/category/about-img-2.png" alt="">
         <h3>what we provide?</h3>
         <marquee style="font-size:30px;" behavior="scrool" direction="left" scrollamount="7">As a super shop, we strive to provide our customers with a wide range of high-quality products to meet their everyday needs. We offer a diverse selection of fresh fruits and vegetables, meats, poultry, seafood, dairy products, baked goods, and pantry staples such as rice, pasta, and beans.</marquee>
         <a href="shop.php" class="btn">our shop</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">OUR TEAM</h1>

   <div class="box-container">

      <div class="box">
         <img src="./images/user/riaad.jpg" alt="">
         <p>Full Stack Developer>>html, css, javascript, php</p>
         
         <h3>Riad Mahamud</h3>
      </div>

      <div class="box">
         <img src="./images/user/mac.jpg" alt="">
         <p>Back-End-Developer>>php, sql</p>
         
         <h3>Fahmid UL Hasan Mac</h3>
      </div>

      <div class="box">
         <img src="./images/user/akash.jpg" alt="">
         <p>Quality Assurance tester>>Project Manager</p>
        
         <h3>Ar Akash Khan</h3>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>