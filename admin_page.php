<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin.css">

</head>
<body>
    <div class="container">
      <div class="navigation">
         <ul>
            <li>
               <a href="admin_page.php">
                  <span class="icon"><ion-icon name="logo-apple-appstore"></ion-icon></span>
                  <span class="title">RMSuperShop</span>
               </a>
            </li>

            <li>
               <a href="admin_orders.php">
                  <span class="icon"><ion-icon name="megaphone-outline"></ion-icon></span>
                  <span class="title">Total Pendings</span>
               </a>
            </li>

            <li>
               <a href="admin_orders.php">
                  <span class="icon"><ion-icon name="trophy-outline"></ion-icon></span>
                  <span class="title">Completed Orders</span>
               </a>
            </li>

            <li>
               <a href="admin_orders.php">
                  <span class="icon"><ion-icon name="reorder-four-outline"></ion-icon></span>
                  <span class="title">Orders Placed</span>
               </a>
            </li>

            <li>
               <a href="admin_products.php">
                  <span class="icon"><ion-icon name="add-outline"></ion-icon></span>
                  <span class="title">Prodcuts Added</span>
               </a>
            </li>

            <li>
               <a href="admin_users.php">
                  <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                  <span class="title">Total Users</span>
               </a>
            </li>

            <li>
               <a href="admin_users.php">
                  <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                  <span class="title">Total Admins</span>
               </a>
            </li>

            <li>
               <a href="admin_users.php">
                  <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                  <span class="title">Total Accounts</span>
               </a>
            </li>
            
            <li>
               <a href="admin_contacts.php">
                  <span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span>
                  <span class="title">See Messages</span>
               </a>
            </li>
            

         </ul>
      </div>
<!-- main -->
<div class="main">
   <div class="topbar">
      <div class="toggle">
      <ion-icon name="grid-outline"></ion-icon>
      </div>
      <!-- search -->
      <div class="search">
         <label>
            <input type="text" name="" id="" placeholder="Search here">
            <ion-icon name="search-outline"></ion-icon>
         </label>
      </div>
      <!-- userImg -->
      <div class="user">
         <a href="admin_update_profile.php"><img src="./images/bg/model26.jpg" alt=""></a>
         
      </div>
   </div>


   <!-- cards -->
<div class="cardBox">
   <div class="card">
      <div>
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['pending']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings += $fetch_pendings['total_price'];
         };
      ?>
         <div class="numbers"><h3>TK<?= $total_pendings; ?>/-</h3></div>
         <div class="cardName">Orders placed</div>
    <br>
         <a href="admin_orders.php" class="btn">see orders</a>
      </div>
      <div class="iconBx">
      <ion-icon name="megaphone-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $total_completed = 0;
         $select_completed = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_completed->execute(['completed']);
         while($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)){
            $total_completed += $fetch_completed['total_price'];
         };
      ?>
         <div class="numbers"><h3>TK<?= $total_completed; ?>/-</h3></div> 
         <div class="cardName">Completed Orders</div> <br>
         <a href="admin_orders.php" class="btn">see orders</a>
      </div>
      <div class="iconBx">
      <ion-icon name="trophy-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $number_of_orders = $select_orders->rowCount();
      ?>
         <div class="numbers"><h3><?= $number_of_orders; ?></h3></div>
         <div class="cardName">Orders placed</div> <br>
         <a href="admin_orders.php" class="btn">see orders</a>
      </div>
      <div class="iconBx">
      <ion-icon name="reorder-four-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
         <div class="numbers"> <h3><?= $number_of_products; ?></h3></div>
         <div class="cardName">Products Added</div> <br>
         <a href="admin_products.php" class="btn">see products</a>
      </div>
      <div class="iconBx">
      <ion-icon name="add-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
         $select_users->execute(['user']);
         $number_of_users = $select_users->rowCount();
      ?>
         <div class="numbers"><h3><?= $number_of_users; ?></h3></div>
         <div class="cardName">Total Users</div> <br>
         <a href="admin_users.php" class="btn">see accounts</a>
      </div>
      <div class="iconBx">
      <ion-icon name="people-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
         $select_admins->execute(['admin']);
         $number_of_admins = $select_admins->rowCount();
      ?>
         <div class="numbers"> <h3><?= $number_of_admins; ?></h3></div>
         <div class="cardName">Total Admins</div> <br>
         <a href="admin_users.php" class="btn">see accounts</a>
      </div>
      <div class="iconBx">
      <ion-icon name="person-circle-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `users`");
         $select_accounts->execute();
         $number_of_accounts = $select_accounts->rowCount();
      ?>
         <div class="numbers"><h3><?= $number_of_accounts; ?></h3></div>
         <div class="cardName">Total Accounts</div> <br>
         <a href="admin_users.php" class="btn">see accounts</a>
      </div>
      <div class="iconBx">
      <ion-icon name="key-outline"></ion-icon>
      </div>
   </div>
   <div class="card">
      <div>
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `message`");
         $select_messages->execute();
         $number_of_messages = $select_messages->rowCount();
      ?>
         <div class="numbers"><h3><?= $number_of_messages; ?></h3></div>
         <div class="cardName">Total Messages</div> <br>
         <a href="admin_contacts.php" class="btn">see messages</a>
      </div>
      <div class="iconBx">
      <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
      </div>
   </div>
</div>
   

<!-- add chart -->

<div class="graphBox">
  
   <div class="box"><canvas id="myChart"></canvas></div>
   <div class="box"><canvas id="earning"></canvas></div>
</div>

<!-- detais -->
<div class="details">
   <div class="recentOrders">
      <div class="cardHeader">
         <h2>Recent Orders</h2>
         <a href="admin_orders.php" class="btn">View All</a>
      </div>
      <table>
         <thead>
            <tr>
               <td>name</td>
               <td>Price</td>
               <td>Payment</td>
               <td>Status</td>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>oil</td>
               <td>TK120</td>
               <td>Paid</td>
               <td><span class="status delivered">Delivered</span></td>
            </tr>

            <tr>
               <td>cake</td>
               <td>TK120000</td>
               <td>Paid</td>
               <td><span class="status delivered">Delivered</span></td>
            </tr>

            <tr>
               <td>orange</td>
               <td>TK120000</td>
               <td>Paid</td>
               <td><span class="status delivered">Delivered</span></td>
            </tr>

            <tr>
               <td>apple</td>
               <td>TK120000</td>
               <td>Paid</td>
               <td><span class="status pending">Pending</span></td>
            </tr>

            <tr>
               <td>meat</td>
               <td>TK120000</td>
               <td>Paid</td>
               <td><span class="status return">Return</span></td>
            </tr>

            <tr>
               <td>fish</td>
               <td>TK120000</td>
               <td>Paid</td>
               <td><span class="status inprogress">Inprogress</span></td>
            </tr>
         </tbody>
      </table>
   </div>

   <!-- new Customers -->

   <div class="recentCustomers">
      <div class="cardHeader">
         <h2>Recent Customers</h2>
      </div>
      <tr>
         <td width="60px"> <div class="imgBx"> <img src="./images/user/pic-1.png" alt=""> </div> </td>
         <td><h4>Malek <br> <span>Mirpur</span> </h4></td>
      </tr>

      <tr>
         <td width="60px"> <div class="imgBx"> <img src="./images/user/pic-2.png" alt=""> </div> </td>
         <td><h4>Rahim <br> <span>Dhanmondi</span> </h4></td>
      </tr>

      <tr>
         <td width="60px"> <div class="imgBx"> <img src="./images/user/pic-3.png" alt=""> </div> </td>
         <td><h4>Shuvo <br> <span>Mirpur</span> </h4></td>
      </tr>

      <tr>
         <td width="60px"> <div class="imgBx"> <img src="./images/user/pic-4.png" alt=""> </div> </td>
         <td><h4>Shumona<br> <span>Gazi pur</span> </h4></td>
      </tr>

      <tr>
         <td width="60px"> <div class="imgBx"> <img src="./images/user/pic-5.png" alt=""> </div> </td>
         <td><h4> Hero Alam <br> <span>Dhaka</span> </h4></td>
      </tr>
   </div>

</div>

</div>


    </div>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./js/chat.js"></script>

<script>
   let toggle = document.querySelector('.toggle');
   let navigation = document.querySelector('.navigation');
   let main = document.querySelector('.main');

   toggle.onclick = function(){
      navigation.classList.toggle('active');
      main.classList.toggle('active');
   }


   let list = document.querySelectorAll('.navigation li');
   function activeLink(){
      list.forEach((item) =>
      item.classList.remive('hovered'));
      this.classList.add('hovered')
   }

   list.forEach((item) => 
   item.addEventListener('mouseover', activeLink));
</script>
</body>
</html>