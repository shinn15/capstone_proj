<?php

session_start();


//$txtt=$_POST['txt1']=print_r($_SESSION);

//verifyer
if(isset($_SESSION["user_id"])){

	$mysqli = require __DIR__ . "/database1.php";

	$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
	//user name
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();

	//echo ("Hello, ".$_SESSION['user_id']);//display current user
}

 //require the user to login if not log in
require "logchecker.php";
?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Campus Clinic Admin Module</title>
	<!---<link rel="stylesheet" type="text/css" href="css/style-admin.css">--->
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	
</head>

<body>

<div class="w3-row">


      <!-- this is the header tab-->
 	<div class="w3-half w3-black w3-container w3-center" style="height:700px">
 		<div class="w3-padding-64">
      <h1>ADMIN DASHBOARD</h1>
    </div>
    	  <div class="w3-padding-64">
		    <a href="admin-sched.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Apointment</a>
			<a href="admin-medrec.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">User Medical Record</a>
			<a href="process-inventory.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Inventory</a>
			<a href="admin-report.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16"> Accounts Records</a>
			<a href="admin-setti.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Settings</a>
			<a href="loginout.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Logout</a>
		</div>
		</div>
	<div class="w3-half w3-blue-grey w3-container" style="height:700px">

	<div class="w3-padding-64 w3-center">
	<h1>ONLINE CLINIC HEALTHCARE SYSTEM</h1>

	<img src="resource/logo.jpg" class="w3-margin w3-circle" alt="logo" style="width:50%">
	<div class="w3-left-align w3-padding-large">
		
	</div>
	</div>
	</div>

</div>




</body>
</html>


