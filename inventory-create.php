 <?php
//add to database
session_start();

$mysqli = require __DIR__ . "/database1.php";

//get current user id
if(isset($_SESSION["user_id"])){

		
		//get current user name

		$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
		$result=mysqli_query($mysqli,$sql);

		//$row=mysqli_fetch_assoc($result);
    
	}


//add to inventory databsae
if(isset($_POST['addit'])){

    $t_up=date("Y-m-d");
    $expire_t=$_POST['item_ex'];
	$itemid=$_POST['iditem'];
	$itemname=$_POST['item_n'];
	$itemnum=$_POST['item_no'];
    
    
    $sqldata1="SELECT * FROM inventory_db WHERE item_id='$itemid'";
    $resulta1=mysqli_query($mysqli,$sqldata1);
    $row1=mysqli_fetch_assoc($resulta1);
    
    $chekid=$row1['item_id'];
    
    $sqldata2="SELECT * FROM inventory_db WHERE item_name='$itemname'";
    $resulta2=mysqli_query($mysqli,$sqldata2);
    $row2=mysqli_fetch_assoc($resulta2);
    
    $chekname=$row2['item_name'];
    
	if ( ! preg_match("/[0-9]/", $_POST['item_no'])){

	  $alert0="<script>alert('Invalid input!'); window.location.href='inventory-create.php'</script>";
	  die($alert0);

	}
	
	if ($chekid==$itemid){

	  $alert2="<script>alert('Item id already taken!'); window.location.href='inventory-create.php'</script>";
	  die($alert2);

	}
	
	if ($chekname==$itemname){

	  $alert10="<script>alert('Item name already taken!'); window.location.href='inventory-create.php'</script>";
	  die($alert10);

	}


	$sql="INSERT INTO inventory_db(time_e,expire_t,item_id,item_name,item_num)
                  VALUES ('$t_up','$expire_t','$itemid','$itemname','$itemnum')";
    $result=mysqli_query($mysqli,$sql);

    //display if succes and show error
    $alert1="<script>alert('Item inserted successfully'); window.location.href='process-inventory.php'</script>";
    
    

    if($result){
    	echo($alert1);
    }else{
    	$error_d=$mysqli -> connect_errno;
    	$alert2="<script>alert('Connection error:'); window.location.href='inventory-create.php'</script>".$error_d;
    	echo($alert2);
    	}

	}

//require the user to login if not log in
require "logchecker.php";

?>



<!DOCTYPE html>
<html>
<head>
	<title>Add Item Page</title>

	<!--css design-->
	<link rel="stylesheet" href="css/style-reg.css">

	<meta charset="utf-8">
</head>
<body>
<!--body form box -->
	<div>
	<div class="logo">
        <img src="resource/logo.jpg" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Add item</h2>
      </div>

		<div class="box_form">
			<div class="button_box">

			

					<form method="post" class="input_txt" >

					
					<!--add id and name tag for php  -->
					    <label for="text">Item Id: </label><br>
						<input type="text" class="input_box" 
						placeholder="Item Id: " id="iditem" name="iditem" required>
                        
                         <label for="text">Item Name: </label><br>
						<input type="text" class="input_box" placeholder="Item Name: " id="item_n" 
						name="item_n" required>
						
						<label for="date">Item Epiration date: </label>
						<input type="date" class="input_box" id="item_ex" name="item_ex" required><br>
                        <br>
                        <label for="text">Item Number: </label><br>
						<input type="text" class="input_box" placeholder="Item Number: " id="item_no" name="item_no" required>


						<button type="submit" id="addit" name="addit">Add Item</button>
						
						<a href="process-inventory.php"><button type="button"class="to_btn">Back</button></a>
					</form>
				</div>
			</div>
		</div>



</body>
</html>