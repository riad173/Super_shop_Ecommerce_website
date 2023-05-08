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
    - primary meta tag
  -->
  <title>RMSUPER SHOP - best shopping experience ever.</title>
  <meta name="title" content="RMShop - Hight Quality Food">
  <meta name="description" content="Riad Mahamud">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./css/shop.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&family=Carter+One&family=Nunito+Sans:wght@400;700&display=swap"
    rel="stylesheet">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="../images/bg/model35.png">

</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <button class="nav-toggle-btn" aria-label="toggle manu" data-nav-toggler>
        <ion-icon name="menu-outline" aria-hidden="true" class="menu-icon"></ion-icon>
        <ion-icon name="close-outline" aria-label="true" class="close-icon"></ion-icon>
      </button>

      <a href="shop.php" class="logo">RMShop</a>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">

          <li class="navbar-item">
            <a href="home.php" class="navbar-link" data-nav-link>Home</a>
          </li>

          <li class="navbar-item">
            <a href="shop.php" class="navbar-link" data-nav-link>Shop</a>
          </li>

          <li class="navbar-item">
            <a href="#" class="navbar-link" data-nav-link>category</a>
          </li>

          <li class="navbar-item">
            <a href="user_profile_update.php" class="navbar-link" data-nav-link>Profile</a>
          </li>

          <li class="navbar-item">
            <a href="about.php" class="navbar-link" data-nav-link>Contact Us</a>
          </li>

        </ul>

        <a href="login.php" class="navbar-action-btn">Log In</a>
      </nav>

      <div class="header-actions">

        <button class="action-btn" aria-label="Search">
        <a href="search_page.php"><ion-icon name="search-outline" aria-hidden="true">  </ion-icon></a>
          
        </button>

        <button class="action-btn user" aria-label="User">
         <a href="user_profile_update.php"><ion-icon name="person-outline" aria-hidden="true"></ion-icon></a>
          
        </button>

        <button class="action-btn" aria-label="cart">
         <a href="cart.php"><ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon></a>
          

          <span class="btn-badge">0</span>
        </button>

      </div>

    </div>
  </header>





  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section class="section hero has-bg-image" id="home" aria-label="home"
        style="background-image: url('../images/bg/ai6.jpg')">
        <div class="container">

          <h1 class="h1 hero-title">
            <span class="span">Get Now</span> RMDoll
          </h1>

          <p class="hero-text">Sale up to 10% off today</p>

          <a href="./page/shop_snacks.php" class="btn">Buy Now</a>

        </div>
      </section>





      <!-- 
        - #CATEGORY
      -->

      <section class="section category" aria-label="category">
        <div class="container">

          <h2 class="h2 section-title">
            <span class="span">Top</span> categories
          </h2>

          <ul class="has-scrollbar">

            <li class="scrollbar-item">
              <div class="category-card">

                <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                  <img src="../images/bg/model36.png" width="330" height="300" loading="lazy" alt="mart"
                    class="img-cover">
                </figure>

                <h3 class="h3">
                  <a href="category.php?category=vegitables" class="card-title">Mart</a>
                </h3>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="category-card">

                <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                  <img src="../images/bg/model10.png" width="330" height="300" loading="lazy" alt="fashion"
                    class="img-cover">
                </figure>

                <h3 class="h3">
                  <a href="#" class="card-title">Fashion</a>
                </h3>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="category-card">

                <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                  <img src="../images/bg/model47.png" width="330" height="300" loading="lazy" alt="Electronic"
                    class="img-cover">
                </figure>

                <h3 class="h3">
                  <a href="#" class="card-title">Electronic</a>
                </h3>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="category-card">

                <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                  <img src="../images/bg/ai3.png" width="330" height="300" loading="lazy" alt="Meat"
                    class="img-cover">
                </figure>

                <h3 class="h3">
                  <a href="category.php?category=meat" class="card-title">Meat</a>
                </h3>

              </div>
            </li>

            <li class="scrollbar-item">
              <div class="category-card">

                <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                  <img src="../images/bg/ai9.png" width="330" height="300" loading="lazy"
                    alt="Snacks" class="img-cover">
                </figure>

                <h3 class="h3">
                  <a href="#" class="card-title">Snacks</a>
                </h3>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #OFFERS
      -->

      <section class="section offer" aria-label="offer">
        <div class="container">

          <ul class="grid-list">

            <li>
              <div class="offer-card has-bg-image img-holder"
                style="background-image: url('../images/bg/ai1.jpg'); --width: 540; --height: 374;">


                <a href="#" class="btn">Buy Now</a>
              </div>
            </li>

            <li>
              <div class="offer-card has-bg-image img-holder"
                style="background-image: url('../images/bg/ai2.jpg'); --width: 540; --height: 374;">

               

        

                <a href="#" class="btn">Buy Now</a>

              </div>
            </li>

            <li>
              <div class="offer-card has-bg-image img-holder"
                style="background-image: url('../images/bg/ai3.jpg'); --width: 540; --height: 374;">

                <a href="#" class="btn">Buy Now</a>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #PRODUCT
      -->

      <section class="section product" id="shop" aria-label="product">
        <div class="container">

          <h2 class="h2 section-title">
            <span class="span">Best</span> Seller
          </h2>

</section>
            

          





      <!-- 
        - #SERVICE
      -->

      <section class="section service" aria-label="service">
        <div class="container">

          <img src="../images/bg/service-icon-1.png" width="122" height="136" loading="lazy" alt="" class="img">

          <h2 class="h2 section-title">
            <span class="span">24/7 Delivery in Dhaka,</span> when you need it.
          </h2>

          <ul class="grid-list">

            <li>
              <div class="service-card">

                <figure class="card-icon">
                  <img src="../images/bg/service-icon-1.png" width="70" height="70" loading="lazy"
                    alt="service icon">
                </figure>

                <h3 class="h3 card-title">Free Same-Day Delivery</h3>

                <p class="card-text">
                  Order by 2pm to 5pm local time to get free delivery on orders TK1,000+ .
                </p>

              </div>
            </li>

            <li>
              <div class="service-card">

                <figure class="card-icon">
                  <img src="../images/bg/service-icon-2.png" width="70" height="70" loading="lazy"
                    alt="service icon">
                </figure>

                <h3 class="h3 card-title">7 Day Return</h3>

                <p class="card-text">
                  35% off your first order plus 5% off all future orders.
                </p>

              </div>
            </li>

            <li>
              <div class="service-card">

                <figure class="card-icon">
                  <img src="../images/bg/service-icon-3.png" width="70" height="70" loading="lazy"
                    alt="service icon">
                </figure>

                <h3 class="h3 card-title">Security payment</h3>

                <p class="card-text">
                  25% off your online order of TK.2500+. Available at most locations .
                </p>

              </div>
            </li>

            <li>
              <div class="service-card">

                <figure class="card-icon">
                  <img src="../images/bg/service-icon-4.png" width="70" height="70" loading="lazy"
                    alt="service icon">
                </figure>

                <h3 class="h3 card-title">24/7 Support</h3>

                <p class="card-text">
                  Shop online to get orders over TK.3500+ shipped fast and free.
                </p>

              </div>
            </li>

          </ul>

        </div>
      </section>





      <!-- 
        - #CTA
      -->

      <section class="cta has-bg-image" aria-label="cta" style="background-image: url('../images/bg/ai5.jpg')">
        <div class="container">

          <figure class="cta-banner">
            <img src="../images/bg/ai4.jpg" width="500" height="500" loading="lazy" alt="cat" class="w100">
          </figure>

          <div class="cta-content">

            <img src="../images/bg/ai7.jpg" width="120" height="35" loading="lazy" alt="taste guarantee"
              class="img">

            

  

            <a href="#" class="btn">Buy Now</a>

          </div>

        </div>
      </section>





      <!-- 
        - #BRAND
      -->

      <section class="section brand" aria-label="brand">
        <div class="container">

          <h2 class="h2 section-title">
            <span class="span">Popular</span> Brands
          </h2>

          <ul class="has-scrollbar">

            <li class="scrollbar-item">
              <div class="brand-card img-holder" style="--width: 150; --height: 150;">
                <img src="../images/bg/brands/asus.png" width="150" height="150" loading="lazy" alt="brand logo"
                  class="img-cover">
              </div>
            </li>

            <li class="scrollbar-item">
              <div class="brand-card img-holder" style="--width: 150; --height: 150;">
                <img src="../images/bg/brands/dng.png" width="150" height="150" loading="lazy" alt="brand logo"
                  class="img-cover">
              </div>
            </li>

            <li class="scrollbar-item">
              <div class="brand-card img-holder" style="--width: 150; --height: 150;">
                <img src="../images/bg/brands/hurley.png" width="150" height="150" loading="lazy" alt="brand logo"
                  class="img-cover">
              </div>
            </li>

            <li class="scrollbar-item">
              <div class="brand-card img-holder" style="--width: 150; --height: 150;">
                <img src="../images/bg/brands/oppo.png" width="150" height="150" loading="lazy" alt="brand logo"
                  class="img-cover">
              </div>
            </li>

            <li class="scrollbar-item">
              <div class="brand-card img-holder" style="--width: 150; --height: 150;">
                <img src="../images/bg/brands/samsung.png" width="150" height="150" loading="lazy" alt="brand logo"
                  class="img-cover">
              </div>
            </li>

          </ul>

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer" style="background-image: url('./assets/images/footer-bg.jpg')">

    <div class="footer-top section">
      <div class="container">

        <div class="footer-brand">

          <a href="#" class="logo">RMSHOP</a>

          <p class="footer-text">
            If you have any question, please contact us at <a href="mail@rmshop.com"
              class="link">mail@rmshop.com</a>
          </p>

          <ul class="contact-list">

            <li class="contact-item">
              <ion-icon name="location-outline" aria-hidden="true"></ion-icon>

              <address class="address">
                Mirpur-2, Dhaka.
              </address>
            </li>

            <li class="contact-item">
              <ion-icon name="call-outline" aria-hidden="true"></ion-icon>

              <a href="tel:+880123456789" class="contact-link">(+880123456789)-</a>
            </li>

          </ul>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-pinterest"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Corporate</p>
          </li>

          <li>
            <a href="#" class="footer-link">Careers</a>
          </li>

          <li>
            <a href="#" class="footer-link">About Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contact Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">FAQs</a>
          </li>

          <li>
            <a href="#" class="footer-link">Vendors</a>
          </li>

          <li>
            <a href="#" class="footer-link">Affiliate Program</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Information</p>
          </li>

          <li>
            <a href="#" class="footer-link">Online Store</a>
          </li>

          <li>
            <a href="#" class="footer-link">Privacy Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Refund Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Shipping Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms of Service</a>
          </li>

          <li>
            <a href="#" class="footer-link">Track Order</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Services</p>
          </li>

          <li>
            <a href="#" class="footer-link">Grooming</a>
          </li>

          <li>
            <a href="#" class="footer-link">Shopping Service</a>
          </li>

          <li>
            <a href="#" class="footer-link">EMI Services</a>
          </li>

          <li>
            <a href="#" class="footer-link">Business Insurance</a>
          </li>

          <li>
            <a href="#" class="footer-link">RMSoft</a>
          </li>

          <li>
            <a href="#" class="footer-link">Resource Center</a>
          </li>

        </ul>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          &copy; 2023 Made with ♥ by <a href="#" class="copyright-link">Riadmahamud</a>
        </p>

        <img src="../images/bg/logo.png" width="397" height="32" loading="lazy" alt="payment method" class="img">

      </div>
    </div>

  </footer>





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script type="text/javascript" src="./js/shop.js" defer></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>