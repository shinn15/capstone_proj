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

	echo ("Hello, ".$_SESSION['user_id']);//display current user
}
//require the user to login if not log in
require "logchecker.php";

//current user
$current_user=$_SESSION['user_id'];

//for old mail
$query_code2="SELECT * FROM medrec_userd WHERE user_curr='$current_user'";
$resulta2=mysqli_query($mysqli,$query_code2);
$row=mysqli_fetch_assoc($resulta2);

$old_mail=$row['email_user'];

if(isset($_POST['submit_c'])){
    
    
    $vercod=$_POST["c_pass"];
    
    
    $query_code="SELECT * FROM login_db WHERE user_in='$current_user'";
    $resulta=mysqli_query($mysqli,$query_code);
    $row=mysqli_fetch_assoc($resulta);
    
    $ver_c=$row['ver_code'];
    $new_mail=$row['user_email'];
    
    //if the verification send not match
    if($vercod != $ver_c){
        
        $query_newmail5="UPDATE login_db SET user_email='$old_mail' WHERE user_in='$current_user'";
       
        
        $query_newmail2="UPDATE medrec_userd SET email_user='$old_mail' WHERE user_curr='$current_user'";
    	$query_newmail3="UPDATE appoint_db SET user_mail='$old_mail' WHERE user_id='$current_user'";
        
        $resulta4=mysqli_query($mysqli,$query_newmail5);
        
        $resulta2=mysqli_query($mysqli,$query_newmail2);
    	$resulta3=mysqli_query($mysqli,$query_newmail3);
        
        
        $alert3 ="<script>alert('Verification code incorrect, Change email unsuccessfull'); window.location.href='user-setti.php'</script>";
	  	die($alert3);
	  	
    //if match
    }else{
        
        
        $query_newmail2="UPDATE medrec_userd SET email_user='$new_mail' WHERE user_curr='$current_user'";
    	$query_newmail3="UPDATE appoint_db SET user_mail='$new_mail' WHERE user_id='$current_user'";
    	
    	$query_newmail4="UPDATE login_db SET verified_email='Verified' WHERE user_in='$current_user'";
    				
    	//call the operation
    	$resulta2=mysqli_query($mysqli,$query_newmail2);
    	$resulta3=mysqli_query($mysqli,$query_newmail3);
    	$resulta4=mysqli_query($mysqli,$query_newmail4);
        
        $alert3 ="<script>alert('Email Verified, New Email Change Successfuly!'); window.location.href='process-userp.php'</script>";
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
<img src="resource/logo.png" alt="Campus Clinic Logo">
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