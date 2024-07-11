<?php

//print("hello")
$mysqli=require __DIR__ . "/database1.php";
session_start();


//$txtt=$_POST['txt1']=print_r($_SESSION);

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

?>

<!DOCTYPE html>
<html>
<head>
	<title>Campus Clinic Admin Page</title>
	<link rel="stylesheet" type="text/css" href="css/style-admin.css">
</head>
<body>
  <div class ='container'>
	<div class="header">
<img src="resource/logo.png" alt="Campus Clinic Logo">
		<h1>Campus Clinic Admin Page</h1>
	</div>
<div class="admin-profile">
        <h2>Inventory Page</h2>


<div class="menu">
		<ul>
			
			<li><a href="process-inventory.php">Inventory Item</a></li>
			<li><a href="invetory-med.php">Inventory Medicine</a></li>

		</ul>
	</div>





<br>
		<a href="admin-page.php"><button>Back</button></a>











</div>


</body>
</html>
