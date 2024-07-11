<?php
//user session start
session_start();

//connect to database
$mysqli=require __DIR__ . "/database1.php";


//test if the user is log in
$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
	//user name
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();




//current user
$current_user=$_SESSION['user_id'];


//if the change pass button is click
if(isset($_POST['submit_c'])){

	$mysqli=require __DIR__ . "/database1.php";


	//
	$current_pass=($_POST["c_pass"]);
	$new_pass=($_POST["n_pass"]);
	$confirm_pass=($_POST["cn_pass"]);

	//password security
	//check if the pass if more than 8 character
	if (strlen($new_pass) < 8 ){

	   $alert1 = "<script>alert('Password must be at least 8 characters!'); window.location.href='admin-setti.php'</script>";
	   die($alert1);
	   //die("Password must be at least 8 characters!");
	   }

	//check if the password have letter
	if ( ! preg_match("/[a-z]/i", $new_pass)){

	   $alert1="<script>alert('Password must contain letter!'); window.location.href='admin-setti.php'</script>";
	   die($alert1);
	   //die("Password must contain letter!");

	   }

	//check password if have a number
	if ( ! preg_match("/[0-9]/", $new_pass)){
	   $alert1 ="<script>alert('Password must contain one number!'); window.location.href='admin-setti.php'</script>";
	   die($alert1);
	   //die("Password must contain one number!");
	   }


	
	//check the old password
	$query_pass="SELECT password_hash FROM login_db WHERE user_in='$current_user'";
	$result=mysqli_query($mysqli,$query_pass);
	$row=mysqli_fetch_assoc($result);

	$old_pass=$row['password_hash'];

	//check if the old password match the current one
	if(password_verify($current_pass,$old_pass)){

		//confirm new pass
		if($new_pass!==$confirm_pass){
			$alert2 ="<script>alert('New password must match!'); window.location.href='admin-setti.php'</script>";
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

			$alert3 ="<script>alert('password change successfully!'); window.location.href='admin-page.php'</script>";
  		die($alert3);

		}

	}
	else{

		$alert1 ="<script>alert('old password not match!'); window.location.href='admin-setti.php'</script>";
  	die($alert1);
	}


	


}



//require the user to login if not log in
require "logchecker.php";


?>

<!DOCTYPE html>

<html>
<head>
	
	<title> Admin Setting Page</title>

	<link rel="stylesheet" href="css/style-reg.css">
	<meta charset="utf-8">
</head>
<body>
	 <div class ='container'>
	<div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
		<h1>Online Clinic Admin Setting</h1>
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

	<a href="admin-page.php"><button type="button"class="to_btn">Back</button></a>
	</form>
</div>


</body>
</html>