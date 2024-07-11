<?php

session_start();

$mysqli = require __DIR__ . "/database1.php";

//verifyer
if(isset($_SESSION["user_id"])){

	$mysqli = require __DIR__ . "/database1.php";

	$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
	//user name
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();

}

//require the user to login if not log in
require "logchecker.php";
//current user
$current_user=$_SESSION['user_id'];

//for eamil sender
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit_c'])){
    
    
    $vercod=($_POST["c_pass"]);
    
    //check verification code
    $query_code="SELECT * FROM login_db WHERE user_in='$current_user'";
    $resulta=mysqli_query($mysqli,$query_code);
    $row=mysqli_fetch_assoc($resulta);
    
    $ver_c=$row['ver_code'];
    
    $usermail=$row['user_email'];
    
    
    //if the verification send not match
    if($vercod != $ver_c){
        
        $query_newmail5="UPDATE login_db SET ver_code='N/A', verified_email='Not_Verified' WHERE user_in='$current_user'";
     
        $resulta4=mysqli_query($mysqli,$query_newmail5);
        
        //email verifier code
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
                    
        $mail->addAddress($usermail);//user email
                    
        $mail->isHTML(true);
                    
                    //
        $ver2_code=substr(number_format(time() * rand(),0,'',''), 0 , 6);
                    
        $mail->Subject ="New User email verification code";
        $mail->Body='<p>Your Email Verification code:<b style="font-size:30px;"> ' . $ver2_code . '</b></p>';
                    
        $mail->send();
         
        $query_newmail50="UPDATE login_db SET ver_code='$ver2_code', verified_email='Not_Verified' WHERE user_in='$current_user'";
     
        $resulta4=mysqli_query($mysqli,$query_newmail50);  
        
        $alert3 ="<script>alert('Verification code incorrect, sending another code'); window.location.href='regemail-verifyer.php'</script>";
	  	die($alert3);
	  	
	  	
    //if match
    }else{
        
    	$query_newmail4="UPDATE login_db SET verified_email='Verified' WHERE user_in='$current_user'";
    				
    	//call the operation

    	$resulta4=mysqli_query($mysqli,$query_newmail4);
        
        $alert3 ="<script>alert('Email Verified Successfuly!'); window.location.href='process-userp.php'</script>";
	  	die($alert3);
        
        
        
       
    }
    
	

    
    
    
    
}
     

?>

<!DOCTYPE html>

<html>
<head>
	
	<title>User Email Verification</title>

	<link rel="stylesheet" href="css/style-reg.css">
	<meta charset="utf-8">
</head>
<body>
	 <div class ='container'>
	<div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
		<h1>Campus Clinic User Verification</h1>
	</div>


  <form method="post">

  	<!--cureent pass-->
  <input type="Text" class="input_box" 
	placeholder="Verification code: " id="c_pass" name="c_pass" required>

	<button type="submit" id="submit_c" name="submit_c">Enter</button>


	</form>



</body>
</html>