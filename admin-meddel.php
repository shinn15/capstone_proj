<?php

$mysqli=require __DIR__ . "/database1.php";

//include 'database1.php';

//delete the id num from database
if(isset($_GET['del_idd'])){


	$id=$_GET['del_idd'];

	//function reminder name of row in sql!
	//delete function
	$sql="DELETE FROM medrec_userd WHERE user_curr='$id'";
	$result=mysqli_query($mysqli,$sql);
	
    $sql2="DELETE FROM medrec_personal WHERE user_curr='$id'";
    $result2=mysqli_query($mysqli,$sql2);
    
    
	//alert success or alert error
	$alert1="<script>alert('Medical Record deleted Successful!'); window.location.href='admin-medrec.php'</script>";
	$error_d=$mysqli -> connect_errno;
    $alert2="<script>alert('Connection error:'); window.location.href='admin-medrec.php'</script>".$error_d;

	if($result){
		//echo "Deleted Successful!";
		echo($alert1);

	}else{

		echo($alert2);
		//die("connection error: " .$mysqli -> connect_errno);

	}
}
