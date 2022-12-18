<?php

// connect to the database
$db = mysqli_connect("localhost", "root", "", "registration");

// get current time
$current_time = time();
$email=$_POST['email'];


// get all users from the database
$query = "SELECT * FROM users where email='$email'";
$result = mysqli_query($db, $query);

while ($user = mysqli_fetch_assoc($result)){
  // get last login time for each user
  $last_login_time = $user['last_login_time'];
    $username = $user['username'];
 
  // calculate the time difference between current time and last login time
  $time_difference = $current_time - $last_login_time;

  // check if it's been more than 24 hours since the user last logged in
  if ($time_difference >= 86400) {
    // send email notification to the user
    $to = $user['sos'];
    $subject = "It's been 1 day since you logged in";
    $message = "Hello, it's been 1 day since '$username' last logged in to our website. !";
    $headers = "From: noreply@ourapplication.com";
    mail($to, $subject, $message, $headers);
  }
}

?>
<html>
    <head>
        Emergency contact
</head>
<body>
<nav class="nav">
      <div class="logo">
           <br>
          <img src="letter-h.png" class="he" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          <t>OMELY </t>
          <br>
      </div>
  </nav>    

  <img src="bg.jpeg" alt="" class="bg">


  <h1>Hurray!!Your contact has been successfully saved!<br>
   Your contact will now on receive a mail if we dont see you around within every 24hours.<br>
   This facility is meant to help you stay safe and help your dear people be assured of your safety.
  </h1>
  <h2>Click the button below to head back to the home page!</h2>
     <a href="home.html"><button href="home.html">Head back </button></a>



   <!--Footer-->
   
   <footer>
       <ul class="icons">
           <li><a href="#"><ion-icon name="logo-whatsapp"></ion-icon></a></li>
           <li><a href="#"><ion-icon name="logo-linkedin"></ion-icon></a></li>
           <li><a href="#"><ion-icon name="logo-facebook"></ion-icon></a></li>
           <li><a href="#"><ion-icon name="logo-instagram"></ion-icon></a></li>
       </ul>
       <ul class="menu">
        <li><a href="login.php">Home</a></li>
        <li><a href="#targt">About</a></li>
        <li><a href="#">Partners</a></li>
        <li><a href="#targt">Specialties</a></li>
        <li><a href="mail to:aathi7257@gmail.com">Contact Us</a></li>
      </ul>
      <br>
      <div class="us">
        
      Build by , <br>Aleena Pascal<br>Anju CS<br>Athira P<br>Shivangi Sudheer Kumar
      </div>
          <div class="footer-copyright">
              <p>Copyright @ 2022 All Rights Reserved.</p>
          </div>
   </footer>