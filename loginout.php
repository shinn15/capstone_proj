<?php

session_start();


$mysqli = require __DIR__ . "/database1.php";

if(isset($_SESSION["user_id"])){

		//get current user name

		$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
		$result=mysqli_query($mysqli,$sql);

		$row=mysqli_fetch_assoc($result);

		$namu=$row['user_n'];//curent user

        $cur_rec=$row['user_in'];
	}


//check the use if it's going to offline
$sqli_up="UPDATE login_db SET user_status='Offline' WHERE user_in ='$cur_rec' ";
$resulta=mysqli_query($mysqli,$sqli_up);

//session_unset();

session_destroy();


header("Location: index.php");

exit;



?>

