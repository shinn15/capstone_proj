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
	$itemid=$_POST['iditem'];
	$itemname=$_POST['item_n'];
	$itemnum=$_POST['item_no'];

	//item num
	if ( ! preg_match("/[0-9]/", $_POST['item_no'])){

  $alert0 ="<script>alert('Invalid input!'); window.location.href='med-create.php'</script>";
   die($alert0);

	}

	$sql="INSERT INTO medinventory_db(e_time,id_item,name_item,num_item)
                  VALUES ('$t_up','$itemid','$itemname','$itemnum')";
    $result=mysqli_query($mysqli,$sql);

    //display if succes and show error
    $alert1="<script>alert('Medicine inserted successfully'); window.location.href='invetory-med.php'</script>";
    
    

    if($result){
    	echo($alert1);
    }else{
    	$error_d=$mysqli -> connect_errno;
    	$alert2="<script>alert('Connection error:'); window.location.href='med-create.php'</script>".$error_d;
    	echo($alert2);
    	}

	}
//require the user to login if not log in
require "logchecker.php";

?>



<!DOCTYPE html>
<html>
<head>
	<title>Add Medicine Page</title>

	<!--css design-->
	<link rel="stylesheet" href="css/style-reg.css">

	<meta charset="utf-8">
</head>
<body>
<!--body form box -->
	<div>
	<div class="logo">
        <img src="resource/logo.png" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Add Medicine</h2>
      </div>

		<div class="box_form">
			<div class="button_box">

			

					<form method="post" class="input_txt" >

					
					<!--add id and name tag for php  -->
						<input type="text" class="input_box" 
						placeholder="Item Id: " id="iditem" name="iditem" required>

						<input type="text" class="input_box" placeholder="Item Name: " id="item_n" 
						name="item_n" required>

						<input type="text" class="input_box" placeholder="Item Number: " id="item_no" name="item_no" required>


						<button type="submit" id="addit" name="addit">Add Item</button>
						
						<a href="invetory-med.php"><button type="button"class="to_btn">Back</button></a>
					</form>
				</div>
			</div>
		</div>



</body>
</html>