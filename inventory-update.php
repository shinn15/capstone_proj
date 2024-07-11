<?php


session_start();

$mysqli = require __DIR__ . "/database1.php";

//get current user id
if(isset($_SESSION["user_id"])){

		
		//get current user name

		$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
		$result=mysqli_query($mysqli,$sql);

		//$row=mysqli_fetch_assoc($result);
    
	}


$id=$_GET['update_id'];

//display old data
$sql="SELECT * FROM inventory_db WHERE id_no='$id'";
$result=mysqli_query($mysqli,$sql);

$row=mysqli_fetch_assoc($result);

$expiret=$row['expire_t'];
$itemid=$row['item_id'];
$itemname=$row['item_name'];
$itemnum=$row['item_num'];


//update to inventory databsae
if(isset($_POST['addit'])){
    $t_up=date("Y-m-d");
	$itemid=$_POST['iditem'];
	$itemname=$_POST['item_n'];
	$itemnum=$_POST['item_no'];
	$exp=$_POST['exp_i'];
	

	//check if the itemnum is no.
	if ( ! preg_match("/[0-9]/", $_POST['item_no'])){
	  $alert0 ="<script>alert('Invalid input!'); window.location.href='inventory-update.php'</script>";
	  die($alert0);

	}
	//update data from database
	$sql="UPDATE inventory_db SET time_e='$t_up',
	                              expire_t='$exp',
	                              item_id='$itemid',
								  item_name='$itemname',
								  item_num='$itemnum' 
								  WHERE id_no='$id'";

    $result=mysqli_query($mysqli,$sql);

    //display if succes or show error
    $alert1="<script>alert('Item updated successfully'); window.location.href='process-inventory.php'</script>";
    $error_d=$mysqli -> connect_errno;
    $alert2="<script>alert('Connection error:'); window.location.href='inventory-update.php'</script>".$error_d;


    //check if updated succesfully if not show error!
    if($result){
    	echo($alert1);
    }else{
    	echo($alert2);
    	}

	}





//require the user to login if not log in
require "logchecker.php";



?>
<!DOCTYPE html>
<html>
<head>
	<title>Update Item Page</title>

	<!--css design-->
	<link rel="stylesheet" href="css/style-reg.css">

	<meta charset="utf-8">
</head>
<body>
<!--body form box -->
	<div class="bodybd">
	<div>
	<div class="logo">
        <img src="resource/logo.jpg" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Update item</h2>
      </div>

		<div class="box_form">
			<div class="button_box">

			

					<form method="post" class="input_txt" >

					
					<!--add id and name tag for php  -->
					<!--value is for displayin old data  -->
					<input type="text" class="input_box" 
						placeholder="Item expiration: " id="exp_i" name="exp_i" value=<?php
								echo($expiret);
							?>>
							
						<input type="text" class="input_box" 
						placeholder="Item Id: " id="iditem" name="iditem" value=<?php
								echo($itemid);
							?>>

						<input type="text" class="input_box" placeholder="Item Name: " id="item_n" 
						name="item_n" value=<?php
								echo($itemname);
							?>>

						<input type="text" class="input_box" placeholder="Item Number: " id="item_no" name="item_no" value=<?php
								echo($itemnum);
							?>>


						<button type="submit" class="to_btn" id="addit" name="addit">Update Item</button>
						
						<a href="process-inventory.php"><button type="button"class="to_btn">Back
						</button></a>
					</form>
				</div>
			</div>
		</div>



</body>
</html>