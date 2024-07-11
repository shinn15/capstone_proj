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
$sql="SELECT * FROM medinventory_db WHERE id_no='$id'";
$result=mysqli_query($mysqli,$sql);

$row=mysqli_fetch_assoc($result);

$itemid=$row['id_item'];
$itemname=$row['name_item'];
$itemnum=$row['num_item'];


//update to inventory databsae
if(isset($_POST['addit'])){
    
    $t_up=date("Y-m-d");
	$itemid=$_POST['iditem'];
	$itemname=$_POST['item_n'];
	$itemnum=$_POST['item_no'];

	if ( ! preg_match("/[0-9]/", $_POST['item_no'])){

	  $alert0 ="<script>alert('Invalid input!'); window.location.href='med-update.php'</script>";
	  die($alert0);

	}

	//update data from database
	$sql="UPDATE medinventory_db SET e_time='$t_up',
	                              id_item='$itemid',
								  name_item='$itemname',
								  num_item='$itemnum' 
								  WHERE id_no='$id'";

    $result=mysqli_query($mysqli,$sql);

    //display if succes or show error
    $alert1="<script>alert('Item updated successfully'); window.location.href='invetory-med.php'</script>";
    $error_d=$mysqli -> connect_errno;
    $alert2="<script>alert('Connection error:'); window.location.href='med-update.php'</script>".$error_d;


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
	<title>Update Medicine Page</title>

	<!--css design-->
	<link rel="stylesheet" href="css/style-reg.css">

	<meta charset="utf-8">
</head>
<body>
<!--body form box -->
	<div class="bodybd">
	<div>
	<div class="logo">
        <img src="resource/logo.png" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Update Medicine</h2>
      </div>

		<div class="box_form">
			<div class="button_box">

			

					<form method="post" class="input_txt" >

					
					<!--add id and name tag for php  -->
					<!--value is for displayin old data  -->
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