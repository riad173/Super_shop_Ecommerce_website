<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tags
  -->
  <title>RMSUPER SHOP - best shopping experience ever.</title>
  <meta name="title" content="RMSuper Shop">
  <meta name="description" content="Where RM Compay there is just comfort">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./css/home.css">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./images/bg/model48.png">
  <link rel="preload" as="image" href="./images/bg/model44.png">
  <link rel="preload" as="image" href="./images/bg/model43.png">

</head>

<body id="top">

  <!-- 
    - #PRELOADER
  -->

  <div class="preload" data-preaload>
    <div class="circle"></div>
    <p class="text">RMSHOP</p>
  </div>





  <!-- 
    - #TOP BAR
  -->

  <div class="topbar">
    <div class="container">

      <address class="topbar-item">
        <div class="icon">
          <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">
         Bangladesh Mirpur, Dhaka;
        </span>
      </address>

      <div class="separator"></div>

      <div class="topbar-item item-2">
        <div class="icon">
          
        </div>

        <span class="span">Bismillahir Rahmanir Raheem</span>
      </div>

      <a href="tel:+88012345678910" class="topbar-item link">
        <div class="icon">
          <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">+88012345678910</span>
      </a>

      <div class="separator"></div>

      <a href="rmshop@email.com" class="topbar-item link">
        <div class="icon">
          <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">rmshop@email.com</span>
      </a>

    </div>
  </div>





  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="home.php" class="logo">
        <img src="./images/bg/logo.png" width="160" height="50" alt="Grilli - Home">
      </a>

      <nav class="navbar" data-navbar>

        <button class="close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>

        <a href="home.php" class="logo">
          <img src="./images/bg/logo.png" width="160" height="50" alt="Grilli - Home">
        </a>

        <ul class="navbar-list">

          <li class="navbar-item">
            <a href="home.php" class="navbar-link hover-underline active">
              <div class="separator"></div>

              <span class="span">Home</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="shop.php" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">Shop</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="about.php" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">About Us</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="user_profile_update.php" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">profile</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="contact.php" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">Contact</span>
            </a>
          </li>

        </ul>

        <div class="text-center">
          <p class="headline-1 navbar-title">Visit Us</p>

          <address class="body-4">
            Facebook: @RMSoft @RMfashion @RMSHOP
          </address>

          <p class="body-4 navbar-text">24/7 Support: Contact Us</p>

          <a href="rmshop@email.com" class="body-4 sidebar-link">rmshop@email.com</a>

          <div class="separator"></div>

          <p class="contact-label">Shop Now</p>

          <a href="tel:+88012345678910" class="body-1 contact-number hover-underline">
          +88012345678910
          </a>
        </div>

      </nav>

      <a href="./fashion/index.html" class="btn btn-secondary">
        <span class="text text-1">LooK AT OuR software</span>

        <span class="text text-2" aria-hidden="true">Buy Now</span>
      </a>

      <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <span class="line line-1"></span>
        <span class="line line-2"></span>
        <span class="line line-3"></span>
      </button>

      <div class="overlay" data-nav-toggler data-overlay></div>

    </div>
  </header>





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="hero text-center" aria-label="home" id="home">

        <ul class="hero-slider" data-hero-slider>

          <li class="slider-item active" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/riad5.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">Sweet Story</p>

            <h1 class="display-1 hero-title slider-reveal">
              Make every day<br>
              sweet with RMSweet
            </h1>

            <p class="body-2 hero-text slider-reveal">
            From Family Feasts to Festavle Treats - Turn Joy into Sweet Story..RMSweet
            </p>

            <a href="category.php?category=snacks" class="btn btn-primary slider-reveal">
              <span class="text text-1">Shop Now</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/ai3.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">Delightful Experience</p>

            <h1 class="display-1 hero-title slider-reveal">
              Best meat form<br>
              panchagarh
            </h1>

            <p class="body-2 hero-text slider-reveal">
              The test of panchagarh.
            </p>

            <a href="category.php?category=meat" class="btn btn-primary slider-reveal">
              <span class="text text-1">SHOP NOW</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/ai4.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">Color full</p>

            <h1 class="display-1 hero-title slider-reveal">
              Taste always <br>
              have color
            </h1>

            <p class="body-2 hero-text slider-reveal">
              rain into color full of vegis...RMShop
            </p>

            <a href="category.php?category=vegitables" class="btn btn-primary slider-reveal">
              <span class="text text-1">SHOP NOW</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>


          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/riad.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">RM Bakires</p>

            <h1 class="display-1 hero-title slider-reveal">
              Where house have RMfashion <br>
              there is Experience
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Eat and fly...RMBakires
            </p>

            <a href="category.php?category=snacks" class="btn btn-primary slider-reveal">
              <span class="text text-1">SHOP NOW</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>


          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/riad4.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">RM Cola</p>

            <h1 class="display-1 hero-title slider-reveal">
              Just Drink It <br>
              Fell the taste later...RMcola
            </h1>

            <p class="body-2 hero-text slider-reveal">
            Refreshing Every sip....RM Cola
            </p>

            <a href="category.php?category=snacks" class="btn btn-primary slider-reveal">
              <span class="text text-1">SHOP NOW</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/riad2.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">RM lemon cola</p>

            <h1 class="display-1 hero-title slider-reveal">
            RM cola now <br>
           in lemon flavour..RMcola
            </h1>

            <p class="body-2 hero-text slider-reveal">
            Refreshing Every sip....RM Cola
            </p>

            <a href="category.php?category=snacks" class="btn btn-primary slider-reveal">
              <span class="text text-1">Shop Now</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/riad6.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">amazing & delicious</p>

            <h1 class="display-1 hero-title slider-reveal">
              Where every flavor <br>
              tells a story
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of healthy food.
            </p>

            <a href="category.php?category=meat" class="btn btn-primary slider-reveal">
              <span class="text text-1">Shop Now</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/model36.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">Fresh, colorful, and packed</p>

            <h1 class="display-1 hero-title slider-reveal">
              Where every healthiness <br>
              there is collor ful world
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="category.php?category=vegitables" class="btn btn-primary slider-reveal">
              <span class="text text-1">Shop Now</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./images/bg/riad3.png" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">Roll in everylife</p>

            <h1 class="display-1 hero-title slider-reveal">
              Roll like pro <br>
              teste like melody
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Hero always eat RMBakires food...RMBakeries
            </p>

            <a href="category.php?category=snacks" class="btn btn-primary slider-reveal">
              <span class="text text-1">Shop Now</span>

              <span class="text text-2" aria-hidden="true">Go to shop</span>
            </a>

          </li>


        </ul>

        <button class="slider-btn prev" aria-label="slide to previous" data-prev-btn>
          <ion-icon name="chevron-back"></ion-icon>
        </button>

        <button class="slider-btn next" aria-label="slide to next" data-next-btn>
          <ion-icon name="chevron-forward"></ion-icon>
        </button>

        <a href="shop.php" class="hero-btn has-after">
          <img src="./images/bg/service-icon-1.png" width="48" height="48" alt="shop now">

          <span class="label-2 text-center span">Shop Now</span>
        </a>

      </section>





      <!-- 
        - #SERVICE
      -->

      <section class="section service bg-black-10 text-center" aria-label="service">
        <div class="container">

          <p class="section-subtitle label-2">MOST SELL</p>

          <h2 class="headline-1 section-title">OUR TOP PRODUCT</h2>

          <p class="section-text">
          Most sell is a top-performing product with high demand and consistent sales, reflecting its quality, value, and relevance to market needs.
          </p>

          <ul class="grid-list">

            <li>
              <div class="service-card">

                <a href="category.php?category=fruits" class="has-before hover:shine">
                  <figure class="card-banner img-holder" style="--width: 285; --height: 336;">
                    <img src="./images/bg/riad.jpg" width="285" height="336" loading="lazy" alt="shoes"
                      class="img-cover">
                  </figure>
                </a>

                <div class="card-content">

                  <h3 class="title-4 card-title">
                    <a href="category.php?category=fruits">Blue Berry</a>
                  </h3>

                  <a href="category.php?category=fruits" class="btn-text hover-underline label-2">Shop Now</a>

                </div>

              </div>
            </li>

            <li>
              <div class="service-card">

                <a href="category.php?category=fruits" class="has-before hover:shine">
                  <figure class="card-banner img-holder" style="--width: 285; --height: 336;">
                    <img src="./images/bg/riad1.jpg" width="285" height="336" loading="lazy" alt="Appetizers"
                      class="img-cover">
                  </figure>
                </a>

                <div class="card-content">

                  <h3 class="title-4 card-title">
                    <a href="category.php?category=fruits">Orange</a>
                  </h3>

                  <a href="category.php?category=fruits" class="btn-text hover-underline label-2">Shop Now</a>

                </div>

              </div>
            </li>

            <li>
              <div class="service-card">

                <a href="category.php?category=oil" class="has-before hover:shine">
                  <figure class="card-banner img-holder" style="--width: 285; --height: 336;">
                    <img src="./images/bg/ai10.png" width="285" height="336" loading="lazy" alt="Drinks"
                      class="img-cover">
                  </figure>
                </a>

                <div class="card-content">

                  <h3 class="title-4 card-title">
                    <a href="category.php?category=oil">RM Oil</a>
                  </h3>

                  <a href="category.php?category=oil" class="btn-text hover-underline label-2">SHOP NOW</a>

                </div>

              </div>
            </li>

          </ul>

          <img src="./images/bg/shape-1.png" width="246" height="412" loading="lazy" alt="shape"
            class="shape shape-1 move-anim">
          <img src="./images/bg/shape-2.png" width="343" height="345" loading="lazy" alt="shape"
            class="shape shape-2 move-anim">

        </div>
      </section>





      <!-- 
        - #ABOUT
      -->

      <section class="section about text-center" aria-labelledby="about-label" id="about">
        <div class="container">

          <div class="about-content">

            <p class="label-2 section-subtitle" id="about-label">Join Us</p>

            <h2 class="headline-1 section-title">Who we are?</h2>

            <p class="section-text">
            Welcome to our RM Soft Solutions. We are a team of passionate and experienced
 professionals who are dedicated to creating innovative software solutions that help
 businesses grow and thrive.At our company, we believe in the power of technology
 to transform the way we live and work. That's why we are committed to developing
 software that is easy to use, reliable, and affordable. Our products are designed to help
 businesses of all sizes streamline their operations, improve their productivity, and increase
 their profitability.But we don't just create great software - we also believe in providing 
exceptional customer service. Our team of experts is always available to answer your
questions, provide technical support, and help you get the most out of our products.
 We value your business and strive to create a positive and rewarding experience for our 
customers. In addition to our commitment to our customers, we are also dedicated to 
increasing our online presence and reaching more potential customers. We are constantl
working to improve our website, create engaging content, and leverage the latest digital
marketing strategies to drive traffic and increase sales. Thank you for considering our 
software solutions. We are confident that our products will help you achieve  your 
business goals and we look forward to working with you.
            </p>

            <div class="contact-label">To Hire Us Call</div>

            <a href="tel: +88012345678910" class="body-1 contact-number hover-underline">+88012345678910</a>

            <a href="about.php" class="btn btn-primary">
              <span class="text text-1">About Us</span>

              <span class="text text-2" aria-hidden="true">Call Now</span>
            </a>

          </div>

          <figure class="about-banner">

            <img src="./images/bg/ai11.png" width="570" height="570" loading="lazy" alt="about banner"
              class="w-100" data-parallax-item data-parallax-speed="1">

            <div class="abs-img abs-img-1 has-before" data-parallax-item data-parallax-speed="1.75">
              <img src="./images/bg/ai12.png" width="285" height="285" loading="lazy" alt=""
                class="w-100">
            </div>

            <div class="abs-img abs-img-2 has-before">
              <img src="./images/bg/riad2.jpg" width="133" height="134" loading="lazy" alt="">
            </div>

          </figure>

          <img src="./images/bg/riad4.jpg" width="197" height="194" loading="lazy" alt="" class="shape">

        </div>
      </section>





      <!-- 
        - #SPECIAL DISH
      -->

      <section class="special-dish text-center" aria-labelledby="dish-label">

        <div class="special-dish-banner">
          <img src="./images/bg/riad3.jpg" width="940" height="900" loading="lazy" alt="special dish"
            class="img-cover">
        </div>

        <div class="special-dish-content bg-black-10">
          <div class="container">

            <img src="./images/bg/shape-7.png" width="28" height="41" loading="lazy" alt="badge" class="abs-img">

            <p class="section-subtitle label-2">RMtoy</p>

            <h2 class="headline-1 section-title">kawasaki ninja h2r </h2>

            <p class="section-text">
            Experience the luxury and style of h2r, crafted with premium materials and designed for effortless elegance.
            </p>

            <div class="wrapper">
              <del class="del body-3">TK: 40,000</del>

              <span class="span body-1">TK: 30,000</span>
            </div>

            <a href="category.php?category=toy" class="btn btn-primary">
              <span class="text text-1">SHOP NOW</span>

              <span class="text text-2" aria-hidden="true">Go to Shop</span>
            </a>

          </div>
        </div>

        <img src="./images/bg/shape-5.png" width="179" height="359" loading="lazy" alt="" class="shape shape-1">

        <img src="./images/bg/shape-1.png" width="351" height="462" loading="lazy" alt="" class="shape shape-2">

      </section>





      <!-- 
        - #MENU
      -->

      <section class="section menu" aria-label="menu-label" id="menu">
        <div class="container">

          <p class="section-subtitle text-center label-2">SPECIAL SELECTION</p>

          <h2 class="headline-1 section-title text-center">Shop By Category</h2>

          <ul class="grid-list">

            <li>
              <div class="menu-card hover:card">

                <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                  <img src="./images/bg/ai.png" width="100" height="100" loading="lazy" alt="fruits"
                    class="img-cover">
                </figure>

                <div>

                  <div class="title-wrapper">
                    <h3 class="title-3">
                      <a href="category.php?category=fruits" class="card-title">Fruits</a>
                    </h3>

                    <span class="badge label-1">Start with</span>

                    <span class="span title-2">TK 250</span>
                  </div>

                  <p class="card-text label-1">
                 Best Fuits of panchagarh...RMshop
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="menu-card hover:card">

                <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                  <img src="./images/bg/ai1.png" width="100" height="100" loading="lazy" alt="Lasagne"
                    class="img-cover">
                </figure>

                <div>

                  <div class="title-wrapper">
                    <h3 class="title-3">
                      <a href="category.php?category=meat" class="card-title">Meat</a>
                    </h3>

                    <span class="badge label-1">Start with</span>

                    <span class="span title-2">TK 800</span>
                  </div>

                  <p class="card-text label-1">
                  Best Meat of panchagarh...RMshop
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="menu-card hover:card">

                <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                  <img src="./images/bg/ai2.png" width="100" height="100" loading="lazy" alt="Butternut Pumpkin"
                    class="img-cover">
                </figure>

                <div>

                  <div class="title-wrapper">
                    <h3 class="title-3">
                      <a href="category.php?category=vegitables" class="card-title">Vegetables</a>
                    </h3>

                    <span class="badge label-1">Start with</span>

                    <span class="span title-2">TK 20</span>
                  </div>

                  <p class="card-text label-1">
                 Best Vegetables of panchagarh...RMshop
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="menu-card hover:card">

                <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                  <img src="./images/bg/ai5.png" width="100" height="100" loading="lazy" alt="Tokusen Wagyu"
                    class="img-cover">
                </figure>

                <div>

                  <div class="title-wrapper">
                    <h3 class="title-3">
                      <a href="category.php?category=snacks" class="card-title">Snacks</a>
                    </h3>

                    <span class="badge label-1">New</span>

                    <span class="span title-2">TK 50</span>
                  </div>

                  <p class="card-text label-1">
                  Best snacks of RMBakeries...RMShop
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="menu-card hover:card">

                <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                  <img src="./images/bg/ai6.png" width="100" height="100" loading="lazy" alt="fish"
                    class="img-cover">
                </figure>

                <div>

                  <div class="title-wrapper">
                    <h3 class="title-3">
                      <a href="category.php?category=fish" class="card-title">Fish</a>
                    </h3>

                    <span class="badge label-1">Start With</span>

                    <span class="span title-2">TK 120</span>
                  </div>

                  <p class="card-text label-1">
                  Best Fish of panchagarh...RMshop
                  </p>

                </div>

              </div>
            </li>

            <li>
              <div class="menu-card hover:card">

                <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                  <img src="./images/bg/ai7.png" width="100" height="100" loading="lazy" alt="beauty"
                    class="img-cover">
                </figure>

                <div>

                  <div class="title-wrapper">
                    <h3 class="title-3">
                      <a href="category.php?category=beauty" class="card-title">Beauty Products</a>
                    </h3>

                    <span class="badge label-1">Start With</span>

                    <span class="span title-2">TK 12,00</span>
                  </div>

                  <p class="card-text label-1">
                 Best beauty products of france..RMShop
                  </p>

                </div>

              </div>
            </li>

          </ul>

          <p class="menu-text text-center">
            Spin and Win Every day <span class="span">7:00 pm</span> to <span class="span">9:00 pm</span>
          </p>

          <a href="./lucky_spinning/index.html" class="btn btn-primary">
            <span class="text text-1">Spin Now</span>

            <span class="text text-2" aria-hidden="true">And Win</span>
          </a>

          <img src="./images/bg/shape-5.png" width="921" height="1036" loading="lazy" alt="shape"
            class="shape shape-2 move-anim">
          <img src="./images/bg/shape-6.png" width="343" height="345" loading="lazy" alt="shape"
            class="shape shape-3 move-anim">

        </div>
      </section>





      <!-- 
        - #TESTIMONIALS
      -->

      <section class="section testi text-center has-bg-image"
        style="background-image: url('./images/bg/ai9.png')" aria-label="testimonials">
        <div class="container">

          <div class="quote">”</div>

          <p class="headline-2 testi-text">
          Thank you for choosing us. We appreciate your health and look forward to serving you again in the future.
          </p>

          <div class="wrapper">
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="separator"></div>
          </div>

          <div class="profile">
            <img src="./images/bg/model26.jpg" width="100" height="100" loading="lazy" alt="Sam Jhonson"
              class="img">

            <p class="label-2 profile-name">Riad Mahamud</p>
          </div>

        </div>
      </section>





      <!-- 
        - #RESERVATION
      -->

      <section class="reservation">
        <div class="container">

          <div class="form reservation-form bg-black-10">

            <form action="" class="form-left">

              <h2 class="headline-1 text-center">RMbakeries</h2>

              <p class="form-text text-center">
                Order Online <a href="tel:+88012345678910" class="link">+88012345678910</a>
                or fill out the order form
              </p>

              <div class="input-wrapper">
                <input type="text" name="name" placeholder="Your Name" autocomplete="off" class="input-field">

                <input type="tel" name="phone" placeholder="Phone Number" autocomplete="off" class="input-field">
              </div>

              <div class="input-wrapper">

                <div class="icon-wrapper">
                  <ion-icon name="person-outline" aria-hidden="true"></ion-icon>

                  <select name="person" class="input-field">
                    <option value="1-person">1 Item</option>
                    <option value="2-person">2 Item</option>
                    <option value="3-person">3 Item</option>
                    <option value="4-person">4 Item</option>
                    <option value="5-person">5 Item</option>
                    <option value="6-person">6 Item</option>
                    <option value="7-person">7 Item</option>
                  </select>

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

                <div class="icon-wrapper">
                  <ion-icon name="calendar-clear-outline" aria-hidden="true"></ion-icon>

                  <input type="date" name="reservation-date" class="input-field">

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

                <div class="icon-wrapper">
                  

                  <select name="person" class="input-field">
                    <option value="08:00am">Dhanmondi Lake</option>
                    <option value="09:00am">Bashundhara City Shopping Mall</option>
                    <option value="010:00am">Gulshan Lake Park</option>
                    <option value="011:00am">Jamuna Future Park</option>
                    <option value="012:00am">Lalbagh Fort</option>
                    <option value="01:00pm">National Parliament House</option>
                    <option value="02:00pm">Ahsan Manzil</option>
                    <option value="03:00pm">Dhakeshwari Temple</option>
                    <option value="04:00pm">Bangladesh National Zoo</option>
                    <option value="05:00pm">New Market</option>
                    <option value="06:00pm">Baitul Mukarram National Mosque</option>
                    <option value="07:00pm">Curzon Hall</option>
                    <option value="08:00pm">Liberation War Museum</option>
                    <option value="09:00pm">Star Mosque</option>
                    <option value="10:00pm">Sonargaon Folk Art and Craft Museum</option>
                  </select>

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

              </div>

              <textarea name="message" placeholder="Message" autocomplete="off" class="input-field"></textarea>

              <button type="submit" class="btn btn-secondary">
                <span class="text text-1">Order Now</span>

                <span class="text text-2" aria-hidden="true">it's Free</span>
              </button>

            </form>

            <div class="form-right text-center" style="background-image: url('./assets/images/form-pattern.png')">

              <h2 class="headline-1 text-center">Contact Us</h2>

              <p class="contact-label">RMbakeries</p>

              <a href="tel:+8801740077206" class="body-1 contact-number hover-underline">+8812345678910</a>

              <div class="separator"></div>

              <p class="contact-label">Location</p>

              <address class="body-4">
                Mirpur 2, Dhaka.
              </address>

              <p class="contact-label">Opening Time</p>

              <p class="body-4">
                Monday to Sunday <br>
                11.00 am - 2.30pm
              </p>

              <p class="contact-label">Night Time</p>

              <p class="body-4">
                Monday to Sunday <br>
                05.00 pm - 10.00pm
              </p>

            </div>

          </div>

        </div>
      </section>





      <!-- 
        - #FEATURES
      -->

      <section class="section features text-center" aria-label="features">
        <div class="container">

          <p class="section-subtitle label-2">Health and Beauty</p>

          <h2 class="headline-1 section-title">Anti-Acne Spot Treatment</h2>

          <ul class="grid-list">

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./images/bg/ai8.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Multi-Use shop</h3>

                <p class="label-1 card-text">Makeup that enhances natural beauty, boosts confidence, and empowers self-expression for a flawless and radiant look.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./images/bg/ai13.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">piniple</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy printing and typesetting.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./images/bg/ai14.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Beauty Tools Kit</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy printing and typesetting.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./images/bg/ai15.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Hair Treatment</h3>

                <p class="label-1 card-text">Lorem Ipsum is simply dummy printing and typesetting.</p>

              </div>
            </li>

          </ul>

          <img src="./images/bg/model29.png" width="208" height="178" loading="lazy" alt="shape"
            class="shape shape-1">

          <img src="./images/bg/model30.png" width="120" height="115" loading="lazy" alt="shape"
            class="shape shape-2">

        </div>
      </section>





      <!-- 
        - #EVENT
      -->

      <section class="section event bg-black-10" aria-label="event">
        <div class="container">

          <p class="section-subtitle label-2 text-center">Recent Updates</p>

          <h2 class="section-title headline-1 text-center">Upcoming Event</h2>

          <ul class="grid-list">

            <li>
              <div class="event-card has-before hover:shine">

                <div class="card-banner img-holder" style="--width: 350; --height: 450;">
                  <img src="./images/bg/model31.png" width="350" height="450" loading="lazy"
                    alt="Flavour so good you’ll try to eat with your eyes." class="img-cover">

                  <time class="publish-date label-2" datetime="2023-09-15">15/09/2023</time>
                </div>

                <div class="card-content">
                  <p class="card-subtitle label-2 text-center">Food, Flavour</p>

                  <h3 class="card-title title-2 text-center">
                    Flavour so good you’ll try to eat with your eyes.
                  </h3>
                </div>

              </div>
            </li>

            <li>
              <div class="event-card has-before hover:shine">

                <div class="card-banner img-holder" style="--width: 350; --height: 450;">
                  <img src="./images/bg/model32.png" width="350" height="450" loading="lazy"
                    alt="Flavour so good you’ll try to eat with your eyes." class="img-cover">

                  <time class="publish-date label-2" datetime="2023-09-08">08/09/2023</time>
                </div>

                <div class="card-content">
                  <p class="card-subtitle label-2 text-center">Healthy Food</p>

                  <h3 class="card-title title-2 text-center">
                    Flavour so good you’ll try to eat with your eyes.
                  </h3>
                </div>

              </div>
            </li>

            <li>
              <div class="event-card has-before hover:shine">

                <div class="card-banner img-holder" style="--width: 350; --height: 450;">
                  <img src="./images/bg/model33.png" width="350" height="450" loading="lazy"
                    alt="Flavour so good you’ll try to eat with your eyes." class="img-cover">

                  <time class="publish-date label-2" datetime="2023-09-03">03/09/2023</time>
                </div>

                <div class="card-content">
                  <p class="card-subtitle label-2 text-center">Fish</p>

                  <h3 class="card-title title-2 text-center">
                    Flavour so good you’ll try to eat with your eyes.
                  </h3>
                </div>

              </div>
            </li>

          </ul>

          <a href="#" class="btn btn-primary">
            <span class="text text-1">View Our News</span>

            <span class="text text-2" aria-hidden="true">On Facebook</span>
          </a>

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer section has-bg-image text-center"
    style="background-image: url('./assets/images/footer-bg.jpg')">
    <div class="container">

      <div class="footer-top grid-list">

        <div class="footer-brand has-before has-after">

          <a href="#" class="logo">
            <img src="./images/bg/logo.png" width="160" height="50" loading="lazy" alt="grilli home">
          </a>

          <address class="body-4">
           Mirpur, Dhaka.
          </address>

          <a href="rmshop@email.com.com" class="body-4 contact-link">rmshop@email.com</a>

          <a href="tel:+88123123456" class="body-4 contact-link">Order Online : +88012345678910</a>

          <p class="body-4">
            Open : 24/7.......
          </p>

          <div class="wrapper">
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="separator"></div>
          </div>

          <p class="title-1">Get News & Offers</p>

          <p class="label-1">
            Subscribe us & Get <span class="span">25% Off.</span>
          </p>

          <form action="" class="input-wrapper">
            <div class="icon-wrapper">
              <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>

              <input type="email" name="email_address" placeholder="Your email" autocomplete="off" class="input-field">
            </div>

            <button type="submit" class="btn btn-secondary">
              <span class="text text-1">Subscribe</span>

              <span class="text text-2" aria-hidden="true">Subscribe</span>
            </button>
          </form>

        </div>

        <ul class="footer-list">

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Home</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Menus</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">About Us</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Our Chefs</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Contact</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Facebook</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Instagram</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Twitter</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Youtube</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Google Map</a>
          </li>

        </ul>

      </div>

      <div class="footer-bottom">

        <p class="copyright">
          &copy; 2023 RMsoft. All Rights Reserved | Crafted by <a href="Riad Mahamud"
            target="_blank" class="link">Riad mahamud</a>
        </p>

      </div>

    </div>
  </footer>





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./js/home.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>