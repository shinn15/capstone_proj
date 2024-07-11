<?php
//user session start
session_start();

//connect to database
$mysqli=require __DIR__ . "/database1.php";


//verifyer
if(isset($_SESSION["user_id"])){

	$mysqli = require __DIR__ . "/database1.php";

	$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
	//user name
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();

	//echo ("Hello, ".$_SESSION['user_id']);//display current user
}

//current user
$current_user=$_SESSION['user_id'];

//for email sending
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//if the change passwrd button is click
if(isset($_POST['submit_c'])){

	$mysqli=require __DIR__ . "/database1.php";


	//
	$current_pass=($_POST['c_pass']);
	$new_pass=($_POST['n_pass']);
	$confirm_pass=($_POST['cn_pass']);

	//password security
	//check if the pass if more than 8 character
	if (strlen($new_pass) < 8 ){

	   $alert1 = "<script>alert('Password must be at least 8 characters!'); window.location.href='user-setti.php'</script>";
	   die($alert1);
	   //die("Password must be at least 8 characters!");
	   }

	//check if the password have letter
	if ( ! preg_match("/[a-z]/i", $new_pass)){

	   $alert1="<script>alert('Password must contain letter!'); window.location.href='user-setti.php'</script>";
	   die($alert1);
	   //die("Password must contain letter!");

	   }

	//check password if have a number
	if ( ! preg_match("/[0-9]/", $new_pass)){
	   $alert1 ="<script>alert('Password must contain one number!'); window.location.href='user-setti.php'</script>";
	   die($alert1);
	   //die("Password must contain one number!");
	   }


	
	//check the old password
	$query_pass="SELECT password_hash FROM login_db WHERE user_in='$current_user'";
	$resulta=mysqli_query($mysqli,$query_pass);
	$rowy=mysqli_fetch_assoc($resulta);

	$old_pass=$rowy['password_hash'];

	//check if the old password match the current one
	if(password_verify($current_pass,$old_pass)){

		//confirm new pass
		if($new_pass!= $confirm_pass){
			$alert2 ="<script>alert('New password must match!'); window.location.href='user-setti.php'</script>";
  		die($alert2);

		}

		//else update the password
		else{
			//hash the new pasword
			$new2pass=password_hash($confirm_pass, PASSWORD_DEFAULT);
			
			//change the password int the database
			$query_newpass="UPDATE login_db SET password_hash='$new2pass' WHERE user_in='$current_user'";
			
			//call the operation
			$resulta=mysqli_query($mysqli,$query_newpass);

			$alert3 ="<script>alert('password change successfully!'); window.location.href='process-userp.php'</script>";
  		die($alert3);

		}

	}
	//else
	else{

		$alert1 ="<script>alert('Current password not match!'); window.location.href='user-setti.php'</script>";
  	die($alert1);
	}


}


//change name
if(isset($_POST['submit_name'])){

	$mysqli=require __DIR__ . "/database1.php";

	//
	$confirm_enpass=($_POST["confirmy_pass"]);
	

	//check the password in database
	$query_npass="SELECT password_hash FROM login_db WHERE user_in='$current_user'";
	$resulti=mysqli_query($mysqli,$query_npass);
	$rowi=mysqli_fetch_assoc($resulti);

	$npass=$rowi['password_hash'];

	//confirm password
	if(password_verify($confirm_enpass,$npass)){

		//change to new name
		$new_name=($_POST["cn_name"]);

		//loop back if the the name is null
		if($new_name == null){
		  
    		$alert4 ="<script>alert('new name needed!'); window.location.href='user-setti.php'</script>";
    	  	die($alert4);


		}
		//change the name code
		else{


			$query_newname="UPDATE login_db SET user_n='$new_name' WHERE user_in='$current_user'";
			
			$query_medrecn="UPDATE medrec_userd SET user_namu='$new_name' WHERE user_curr='$current_user'";
			
			$query_newname2="UPDATE appoint_db SET n_user='$new_name' WHERE user_id='$current_user'";

				
				//call the operation
			$resulta=mysqli_query($mysqli,$query_newname);
			$resulta2=mysqli_query($mysqli,$query_medrecn);
			$resulta3=mysqli_query($mysqli,$query_newname2);

			$alert3 ="<script>alert('name change successfully!'); window.location.href='process-userp.php'</script>";
	  	die($alert3);


		}

		
	}

	//else
	else{

		$alert1 ="<script>alert('password need to match to change name!'); window.location.href='user-setti.php'</script>";
  	die($alert1);

	}

}

//change email
if(isset($_POST['submit_mail'])){

	$mysqli=require __DIR__ . "/database1.php";

	//
	$confirm_npass=($_POST["confirmy_empass"]);
	
    //check if the input is email
	/*$checkem = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if ( ! preg_match($checkem, $_POST["em_name"])){
        $alert1 ="<script>alert('Invalid Email!'); window.location.href='user-setti.php'</script>";
        echo($alert1);
        }*/

	//check the password in database
	$query_pass="SELECT password_hash FROM login_db WHERE user_in='$current_user'";
	$result=mysqli_query($mysqli,$query_pass);
	$row=mysqli_fetch_assoc($result);

	$mpass=$row['password_hash'];

	//confirm password
	if(password_verify($confirm_npass,$mpass)){

		//change to new email
		$new_mail=($_POST["em_name"]);

        //check if email alredy used
        $ch_query="SELECT * FROM login_db WHERE user_email ='$new_mail'";
        $result=mysqli_query($mysqli,$ch_query);
        $row=mysqli_fetch_assoc($result);
            
        $chk_m=$row['user_email'];
        if($chk_m==$new_mail){
            
            $alert1 ="<script>alert('Email already used!'); window.location.href='user-setti.php'</script>";
            die($alert1);
        }
        
		//loop back if the the email is null
		if($new_mail == null){

			$alert4 ="<script>alert('new email needed!'); window.location.href='user-setti.php'</script>";
	  	die($alert4);


		}
		
		else{
		    
		    //send verification code to email
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
            
            $mail->addAddress($new_mail);//user email
            
            $mail->isHTML(true);
            
            //
            $ver_code=substr(number_format(time() * rand(),0,'',''), 0 , 6);
            
            $mail->Subject ="Email Verification code";
            $mail->Body='<p>Your Email Verification code:<b style="font-size:30px;">' . $ver_code . '</b></p>';
            
            $mail->send();
            
            //send code to table
            $query_ver="UPDATE login_db SET user_email='$new_mail', ver_code='$ver_code', verified_email='Not_Verified' WHERE user_in='$current_user'";
            
            $resulta=mysqli_query($mysqli,$query_ver);
            
			$alert3 ="<script>alert('Email need to verify to change successfully!'); window.location.href='email-verifyer.php'</script>";
	  	    die($alert3);


		}

		
	}

	//else
	else{

		$alert1 ="<script>alert('password need to match to change email!'); window.location.href='user-setti.php'</script>";
  	die($alert1);

	}

}

//change username
if(isset($_POST['submit_usern'])){

	$mysqli=require __DIR__ . "/database1.php";

	//
	$confirm_upass=($_POST["confirmy_uspass"]);
	
    //check if the input is email

	//check the password in database
	$query_upass="SELECT password_hash FROM login_db WHERE user_in='$current_user'";
	$resultu=mysqli_query($mysqli,$query_upass);
	$rowu=mysqli_fetch_assoc($resultu);

	$rpass=$rowu['password_hash'];

	//confirm password
	if(password_verify($confirm_upass,$rpass)){

		//change to new email
		$new_usern=($_POST["usr_name"]);

		//loop back if the the email is null
		if($new_usern == null){

			$alert4 ="<script>alert('new user name needed!'); window.location.href='user-setti.php'</script>";
	  	die($alert4);


		}
		//change the username code
		else{


			$query_newuser="UPDATE login_db SET user_in='$new_usern' WHERE user_in='$current_user'";
			$query_newuser2="UPDATE medrec_personal SET user_curr='$new_usern' WHERE user_curr='$current_user'";
			$query_newuser3="UPDATE medrec_userd SET user_curr='$new_usern' WHERE user_curr='$current_user'";
			$query_newuser4="UPDATE appoint_db SET user_id='$new_usern' WHERE user_id='$current_user'";

			
			
				
				//call the operation
			$resulta=mysqli_query($mysqli,$query_newuser);
			$resulta=mysqli_query($mysqli,$query_newuser2);
			$resulta=mysqli_query($mysqli,$query_newuser3);
			$resulta=mysqli_query($mysqli,$query_newuser4);

			$alert3 ="<script>alert('User name change successfully!'); window.location.href='process-userp.php'</script>";
	  	die($alert3);


		}

		
	}

	//else
	else{

		$alert1 ="<script>alert('password need to match to change user name!'); window.location.href='user-setti.php'</script>";
  	die($alert1);

	}

}



//require the user to login if not log in
require "logchecker.php";


?>

<!DOCTYPE html>

<html>
<head>
	
	<title> User Setting Page</title>

	<link rel="stylesheet" href="css/style-reg.css">
	<meta charset="utf-8">
</head>
<body>
	 <div class ='container'>
	<div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
		<h1>Online Clinic User Setting</h1>
	</div>
	
<!-- Settings Tab -->
<div id="settings" class="tabcontent" style="display:block">
  <h3>Change Password</h3>

  
  <form method="post">

  	<!--cureent pass-->
  <input type="password" class="input_box" 
	placeholder="Current Password: " id="c_pass" name="c_pass" required>

	<input type="password" class="input_box" placeholder="New Password: " id="n_pass" name="n_pass" required>

	<input type="password" class="input_box" placeholder="Comfirm New Password: " id="cn_pass" name="cn_pass">


	<button type="submit" id="submit_c" name="submit_c">Change Password</button>


	</form>
</div>


<!--name setti-->

	<h3>Change Name</h3>
  
  <form method="post">

  	<!--cureent pass-->
  <input type="password" class="input_box" 
	placeholder="Current password for confirmation: " id="confirmy_pass" name="confirmy_pass" required>

	<input type="Text" class="input_box" placeholder="New Name: " id="cn_name" name="cn_name">

	


	<button type="submit" id="submit_name" name="submit_name">Change Name</button>

	
	</form>

	
<!--email setti-->
	<h3>Change Email</h3>
  
  <form method="post">

  	<!--cureent pass-->
  <input type="password" class="input_box" 
	placeholder="Current password for confirmation: " id="confirmy_empass" name="confirmy_empass" required>

	<input type="Text" class="input_box" placeholder="New Email: " id="em_name" name="em_name">


	<button type="submit" id="submit_mail" name="submit_mail">Change Email</button>

	</form>


<!--username setti-->


	<h3>Change UserID</h3>
  
  <form method="post">

  	<!--cureent pass-->
  <input type="password" class="input_box" 
	placeholder="Current password for confirmation: " id="confirmy_uspass" name="confirmy_uspass" required>

	<input type="Text" class="input_box" placeholder="New User name: " id="usr_name" name="usr_name">

	


	<button type="submit" id="submit_usern" name="submit_usern">Change User name</button>

	<a href="process-userp.php"><button type="button"class="to_btn">Back</button></a>
	</form>



	
</div>




</body>
</html>