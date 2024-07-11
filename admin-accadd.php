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

if(isset($_POST['ad_addit'])){
    //error_reporting(0); ignore error";
    
    
    //userid
    //studentno = username
    
    //check student full name
    if (strlen($_POST['f_name']) < 7 ){
        //display the error and redirect
       $alert1="<script>alert('Invalid Full Name!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
    
    }
    
    if (strlen($_POST['userm']) < 5 ){
       //display the error and redirect
       $alert1="<script>alert('User name should be 5+ character!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
    
    }
    
    //for email
    $checkem = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if ( ! preg_match($checkem, $_POST['usereml'])){
    
      $alert1 ="<script>alert('Invalid Email!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
    
    }
    
    //password security
    
    if (strlen($_POST['passwordr']) < 8 ){
    
       $alert1 = "<script>alert('Password must be at least 8 characters!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
       //die("Password must be at least 8 characters!");
       }
    
    if ( ! preg_match("/[a-z]/i", $_POST['passwordr'])){
    
       $alert1="<script>alert('Password must contain letter!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
       //die("Password must contain letter!");
    
       }
    
    if ( ! preg_match("/[0-9]/", $_POST['passwordr'])){
       $alert1 ="<script>alert('Password must contain one number!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
       //die("Password must contain one number!");
       }
    
    
    if ($_POST['passwordr'] !== $_POST['confirm_pass']){
       $alert1 = "<script>alert('Password must match!'); window.location.href='admin-accadd.php'</script>";
       die($alert1);
       //die("Password must match");
    
    
       }
    
    
    //exit();
    
    
    
    //secure the pas
    $pass_hash=password_hash($_POST['passwordr'], PASSWORD_DEFAULT);
    //authority
    $autho='user';
    
    
    //return information to database1 file
    $mysqli=require __DIR__ . "/database1.php";
    
    
    //insert into table database
    $sql="INSERT INTO login_db(user_n,auth,user_email,user_in,password_hash)
                      VALUES (?,?,?,?,?)";
    
    //check if error
    $stmt=$mysqli ->stmt_init();
    
    if ( ! $stmt->prepare($sql)){
    
       die("SQL ERROR: " . $mysqli -> error);
    }
    
    //add data to database
    $stmt->bind_param("sssss",
                      $_POST['f_name'],
                      $autho,
                      $_POST['usereml'],//email
                      $_POST['userm'],//user name
                      $pass_hash);
    
    
    
    //check if account already taken and Register account
    if ($stmt->execute()){
    
    
       $alert102 = "<script>alert('Account successsfuliy created!'); window.location.href='admin-report.php'</script>";
       die($alert102);
       exit;
    
    }else{
        //if rgeres already accoutnt
       if($mysqli -> errno === 1062){
          $alert101 = "<script>alert('Account Already Taken!'); window.location.href='admin-accadd.php'</script>";
          die($alert101);
       }else{
    
          die($mysqli -> error . " " . $mysqli -> errno);
       }  
    }


}

//require the user to login if not log in
require "logchecker.php";

?>

<!DOCTYPE html>
<html>
  <head>
    <!-- Set the title of the page -->
    <title>Admin user account create</title>
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="css/style-reg.css">
  </head>
  <body>
    <!-- Create a container to hold the page content and center it horizontally -->
    <div class="container">
      <!-- Create a form section for the registration form -->
      <div class="form">

        <form method="post">
      <!-- Create a header section for the logo and title of the page -->
        <div class="header">
        <!-- Insert the title of the page -->
        <h1>Online Clinic Healthcare System</h1>
        <!-- Insert the logo image and add alternative text -->
      <div class="logo">
        <img src="resource/logo.png" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Create account</h2>
      </div>
          <!-- Create input fields for the user's first name, last name, email, and password -->
          <label for="first_name">Full Name:</label>
          <input type="text" id="f_name" name="f_name"><br><br>

          <label for="text">User Id:</label>
          <input type="text" id="userm" 
            name="userm" required><br><br>
            
          <label for="text">Email:</label>
          <input type="text" id="usereml" 
            name="usereml" required><br><br>

          <label for="password">Password:</label>
          <input type="password" id="passwordr" name="passwordr" required><br><br>

          <label for="password">Confirm Password:</label>
          <input type="password" id="confirm_pass" 
          name="confirm_pass"><br><br>

          <!-- Create a submit button for the form -->
          	<button type="submit" id="ad_addit" name="ad_addit">Add Account</button>
						
			<a href="admin-report.php"><button type="button"class="to_btn">Back</button></a>

       
        </form>
      </div>
    </div>
  </body>
</html>


