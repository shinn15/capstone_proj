<?php

$mysqli=require __DIR__ . "/database1.php";

//include 'database1.php';

//delete the id num from database
if(isset($_GET['del_id'])){


	$id=$_GET['del_id'];

	//function reminder name of row in sql!
	$sql="DELETE FROM inventory_db WHERE id_no='$id'";

	$result=mysqli_query($mysqli,$sql);

	//alert success or alert error
	$alert1="<script>alert('Deleted Successful!'); window.location.href='process-inventory.php'</script>";
	$error_d=$mysqli -> connect_errno;
    $alert2="<script>alert('Connection error:'); window.location.href='process-inventory.php'</script>".$error_d;

	if($result){
		//echo "Deleted Successful!";
		echo($alert1);

	}else{

		echo($alert2);
		//die("connection error: " .$mysqli -> connect_errno);

	}
}





?>