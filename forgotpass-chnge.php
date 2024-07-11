<?php

$mysqli=require __DIR__ . "/database1.php";

//usermail
$u_email=$_GET['us_mail'];

if(isset($_POST['submit_p'])){
    
	$new_pass=($_POST['chn_p']);
	$confirm_pass=($_POST['chn_p2']);
    
	//password security
	//check if the pass if more than 8 character
	if (strlen($new_pass) < 8 ){
	    
	    $alert1="<script>alert('Password must be at least 8 characters!'); window.location.href='forgotpass-chnge.php?u_email=$u_email'</script>";
	    echo($alert1);
	   }
    
	//check if the password have letter
	if ( ! preg_match("/[a-z]/", $new_pass)){
            
	    $alet1="<script>alert('Password must contain letter!');window.location.href='forgotpass-chnge.php?u_email=$u_email'</script>";
	    echo($alert1);

	   }

	//check password if have a number
	if ( ! preg_match("/[0-9]/", $new_pass)){
	    
	    $alert1="<script>alert('Password must contain one number!'); window.location.href='forgotpass-chnge.php?u_email=$u_email'</script>";
	    echo($alert1);
	   }
	
	//confirm new pass
	if($new_pass!==$confirm_pass){
	    
		$alert1="<script>alert('New password must match!'); window.location.href='forgotpass-chnge.php?u_email=$u_email'</script>";
  		echo($alert1);

	}

		//else update the password
	else{
	    
			//hash the new pasword
		$new2pass=password_hash($confirm_pass, PASSWORD_DEFAULT);
			
			//change the password int the database
		$query_newpass="UPDATE login_db SET password_hash='$new2pass' WHERE user_email='$u_email'";
			
			//call the operation
		$resulta=mysqli_query($mysqli,$query_newpass);

		$alert3 ="<script>alert('password change successfully!'); window.location.href='index.php'</script>";
  		die($alert3);

		}

    
    
}







?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Set the title of the page -->
    <title>Online Clinic Healthcare System - Forgot password</title>
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="css/style-reg.css">
  </head>
  <body>

<div class="header">
        <!-- Insert the title of the page -->
        <h1>Online Clinic Healthcare System</h1>
        <!-- Insert the logo image and add alternative text -->
      <div class="logo">
        <img src="resource/logo.jpg" alt="Campus Clinic Logo">
        </div>
          <!-- Create a heading for the form -->
          <h2>Forgot Password Form</h2>
      </div>

    <form method="post">
         <label for="password">Enter New Password:</label>
          <input type="password" id="chn_p" name="chn_p" required><br>
          
            <label for="password">Confirm Password:</label>
          <input type="password" id="chn_p2" name="chn_p2" required><br>
        
        	<button type="submit" id="submit_p" name="submit_p">Change Password</button>
        
        
        
        
        
        
    </form>


</body>
</html>