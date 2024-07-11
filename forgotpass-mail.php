<?php

$mysqli = require __DIR__ . "/database1.php";

//usermail
$u_email=$_GET['cd_mail'];

//check if the verification code match
if(isset($_POST['submit_cd'])){
    
    $vercod=$_POST["ver_c"];
    
    $ch_query="SELECT * FROM login_db WHERE user_email ='$u_email'";
    $result=mysqli_query($mysqli,$ch_query);
    $row=mysqli_fetch_assoc($result);
    
    //email
    $chk_m=$row['user_email'];
    
    //ver code
    $chk_cd=$row['ver_code'];
    
    if($vercod != $chk_cd){
        
        $alert3 ="<script>alert('Verification code incorrect'); window.location.href='forgot-pass.php'</script>";
	  	die($alert3);
    }else{
        
        $alert3 ="<script>alert('Verification code match change password'); window.location.href='forgotpass-chnge.php?us_mail=$chk_m'</script>";
	  	die($alert3);
    }
    
    
    
}



?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Set the title of the page -->
    <title>Online Clinic Healthcare System - Forgot password</title>
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="css/style-reg.css">
  </head>
  <body>

<div class="header">
        <!-- Insert the title of the page -->
        <h1>Online Clinic Healthcare System</h1>
        <!-- Insert the logo image and add alternative text -->
      <div class="logo">
        <img src="resource/logo.jpg" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Forgot Password Form</h2>
      </div>

    <form method="post">
        
         <label for="text">Enter Verification code:</label>
          <input type="text" id="ver_c" name="ver_c" required><br>
        
        	<button type="submit" id="submit_cd" name="submit_cd">Enter</button>
        
        
        
        
        
        
    </form>


</body>
</html>