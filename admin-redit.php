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


$id=$_GET['edt_id'];

//display old data
$sql="SELECT * FROM login_db WHERE id_no='$id'";
$result=mysqli_query($mysqli,$sql);

$row=mysqli_fetch_assoc($result);


$usern=$row['user_n'];
$usermail=$row['user_email'];
$userid=$row['user_in'];
$userauth=$row['auth'];


//update databsae
if(isset($_POST['addit'])){
    $t_up=date("Y-m-d");
	$usnr=$_POST['usr_n'];
	$usrem=$_POST['usr_em'];
	$usrid=$_POST['usr_id'];
    $usrauth=$_POST['auth_usr'];
    
    //check auth
    if($usrauth==$_POST['auth_0']){
     	//display the error and redirect
        $alert101="<script>alert('Please choose your authorization!'); window.location.href='admin-report.php'</script>";
        die($alert101);
    
    }
    //check email
    $checkem = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if ( ! preg_match($checkem, $_POST['usr_em'])){
        
        $alert1 ="<script>alert('Invalid Email!'); window.location.href='admin-report.php'</script>";
        die($alert1);

    }
    
    
	//update data from database
	$sql="UPDATE login_db SET date_update='$t_up',
	                              user_n='$usnr',
	                              user_email='$usrem',
								  user_in='$usrid',
								  auth='$usrauth' 
								  WHERE id_no='$id'";

    $result=mysqli_query($mysqli,$sql);

    //display if succes or show error
    $alert1="<script>alert('Account edited successfully'); window.location.href='admin-report.php'</script>";
    $error_d=$mysqli -> connect_errno;
    $alert2="<script>alert('Connection error:'); window.location.href='admin-report.php'</script>".$error_d;


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
          <h2>Edit user account</h2>
      </div>

		<div class="box_form">
			<div class="button_box">

			

					<form method="post" class="input_txt" >

					
					<!--add id and name tag for php  -->
					<!--value is for displayin old data  -->
						<input type="text" class="input_box" 
						placeholder="User name: " id="usr_n" name="usr_n" value=<?php
								echo($usern);
							?>>

						<input type="text" class="input_box" placeholder="User email: " id="usr_em" 
						name="usr_em" value=<?php
								echo($usermail);
							?>>

						<input type="text" class="input_box" placeholder="User Id: " id="usr_id" name="usr_id" value=<?php
								echo($userid);
							?>>
							
						<label for="select">Authorization: </label>
                        <select id="auth_usr" name="auth_usr" tabindex="1" size="1" style="width: 240px;">
                        		<option id="auth_0" selected value=""> <?php echo($userauth); ?> </option>
                        		<option id="usr_auth" value="user" >user</option>
                        		<option id="adm_auth" value="admin" >admin</option>
                        		
                        </select>

                        <br>
                        <br>
						<button type="submit" class="to_btn" id="addit" name="addit">Enter</button>
						
						<a href="admin-report.php"><button type="button"class="to_btn">Back</button></a>
					</form>
				</div>
			</div>
		</div>



</body>
</html>