<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
  <link rel="stylesheet" href="./css/login.css">

</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<section class="form-container">

<div class="form-box">
   <div class="form-value">
   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Register Now</h3>

      <div class="inputbox">
      <ion-icon name="person-circle-outline"></ion-icon>
      <input type="text" name="name" class="box" required>
      <label for="">Name</label>
      </div>

      <div class="inputbox">
      <ion-icon name="mail-outline"></ion-icon>
      <input type="email" name="email" class="box" required>
      <label for="">Email</label>
      </div>

      <div class="inputbox">
      <ion-icon name="lock-closed-outline"></ion-icon>
      <input type="password" name="pass" class="box" required>
      <label for="">Password</label>
      </div>

      <div class="inputbox">
      <ion-icon name="lock-closed-outline"></ion-icon>
      <input type="password" name="cpass" class="box" required>
      <label for="">Confirm Password</label>
      </div>

      <div class="inputbox">
      <ion-icon name="image-outline"></ion-icon>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      </div>

      <input type="submit" value="register now" class="btn" name="submit">
      <div class="register">
      <p>Already have an account? <a href="login.php">login now</a></p>
      </div>
     


   </div>
</div>
   </form>

</section>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>