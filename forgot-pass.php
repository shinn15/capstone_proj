<?php

$mysqli = require __DIR__ . "/database1.php";

//for email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit_f'])){
    //check email
    $checkem = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if ( ! preg_match($checkem, $_POST['usereml'])){
        
        $alert1 ="<script>alert('Enter valid Email!'); window.location.href='forgot-pass.php'</script>";
        die($alert1);

    }
    
    //check if email is in database
    $imal=$_POST['usereml'];
    
    $ch_query="SELECT * FROM login_db WHERE user_email ='$imal'";
    $result=mysqli_query($mysqli,$ch_query);
    $row=mysqli_fetch_assoc($result);
    
    $chk_m=$row['user_email'];
    
    if($chk_m==null){
        
        $alert1="<script>alert('User email account not found!'); window.location.href='forgot-pass.php'</script>";
  		die($alert1);
        
    }
    else{
        $mail = new PHPMailer(true);
    
        $mail->isSMTP();
        $mail->Host= 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username='grouphcapstone072@gmail.com';//sender email
        $mail->Password='pnyj dyes oyep odmm';//app password gmail
        $mail->SMTPSecure='ssl';
        $mail->Port=465;
                    
                    //user receiver
        $mail->setFrom('grouphcapstone072@gmail.com');
                    
        $mail->addAddress($imal);//user email
                    
        $mail->isHTML(true);
                    
                    //send code
        $ver2_code=substr(number_format(time() * rand(),0,'',''), 0 , 6);
                    
        $mail->Subject ="New User email verification code";
        $mail->Body='<p>Your Email Verification code:<b style="font-size:30px;"> ' . $ver2_code . '</b></p>';
                    
        $mail->send();
        
        $query_newcode="UPDATE login_db SET ver_code='$ver2_code' WHERE user_email='$imal'";
        $resulta2=mysqli_query($mysqli,$query_newcode);
        
        $alert1="<script>alert('Verification code send to email!'); window.location.href='forgotpass-mail.php?cd_mail=$imal'</script>";
  		die($alert1);
  		exit;
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
        
         <label for="text">Enter Account Email:</label>
          <input type="text" id="usereml" name="usereml" required><br>
        
        	<button type="submit" id="submit_f" name="submit_f">Enter</button>
        
        
        
        
        
        
    </form>


 <div class="login-link">
          Back to Login page? <a href="index.php">Log in</a>
</div>




</body>
</html>