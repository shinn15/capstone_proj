<?php

session_start();

$mysqli = require __DIR__ . "/database1.php";


//get current user id
if(isset($_SESSION["user_id"])){

		//get current user name

		$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
		$result=mysqli_query($mysqli,$sql);

		$row=mysqli_fetch_assoc($result);

		$namu=$row['user_n'];
		
    //echo ("Hello, ".$_SESSION['user_id']);//display current user
    
	}
$current_user=$_SESSION['user_id'];//curent user


//redirect for email verification
$ver_mail="SELECT * FROM login_db WHERE user_in='$current_user'";
$resulta=mysqli_query($mysqli,$ver_mail);
$row=mysqli_fetch_assoc($resulta);

$email_ver=$row['verified_email'];

if($email_ver=='Not_Verified'){
    $alert102 = "<script>alert('Email need verification'); window.location.href='regemail-verifyer.php'</script>";
    die($alert102);
    
}

//require the user to login if not log in
require "logchecker.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User page</title>

  <!---<link rel="stylesheet" href="css/style-user.css">--->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    
<div class="w3-row w3-black">

  <!-- Navigation section -->
  <div class="w3-half w3-black w3-container w3-center">
    <div class="w3-padding-64">
      <h1>USER DASHBOARD</h1>
    </div>

    <div class="w3-padding-64">
      <a href="process-appoint.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Appointments</a>
      <a href="process-presic.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Medical Record</a>
      <a href="process-medrec.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Medical History</a>
      <a href="user-setti.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Settings</a>
      <!--logout-->
      <a  href="loginout.php" class="w3-button w3-black w3-block w3-hover-blue-grey w3-padding-16">Logout</a>
    </div>
 </div>
  
  <!-- Main section -->
<div class="w3-half w3-blue-grey w3-container">
  <div class="w3-padding-64 w3-center">
    <div style="overflow-x:auto;">
    <img src="resource/logo.jpg" class="w3-margin w3-circle" alt="logo" style="width:20%">
    <div class="w3-padding-64 w3-center">
  <h1>
    <?php 
      //display current user name
    echo ("Hello, ".$namu);
  
  ?>
  
 </h1>
  <main>
  
    <!---show apointments--->
    <h3>Upcoming Appointments</h3>

  <table class="w3-table">
      <tr>  
        <th>Date</th>
        <th>Time</th>
        
      </tr>

        <?php
        //extract time information
        $sql="SELECT * FROM appoint_db WHERE user_id='$current_user' ";
        $result=mysqli_query($mysqli,$sql);

        if($result){
          while($row=mysqli_fetch_assoc($result)){
   
            $petsa=$row['date_appoint'];
            $petsa2=date('F/d/Y',strtotime($petsa));
            $oras=$row['timeslot'];
            $nowy=date("Y-m-d H:i:s");//today time
            
            //check if the appointment is today
            if($petsa==$nowy){
              $isoverpoint="You have appointment today!";
              $orasan=$oras;
            }
            //check if the appointment is over 
            elseif($petsa<$nowy){
              $isoverpoint=$petsa2;
              $orasan="N/A";
            }else{
              $isoverpoint=$petsa2;
              $orasan=$oras;
            } 


            //show inventory information
            //id is for easily locate object
            $table_data="
            <tr>
              <td>$isoverpoint</td>
              <td>$orasan</td>
     
            </tr>";


            echo($table_data);

          }
        }

        ?>


      
  

</table>


</main>
  
  </div>
  </div>
</div>
  </div>









</div>
  
</body>
</html>
