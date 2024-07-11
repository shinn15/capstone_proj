<?php

//print("hello")
$mysqli=require __DIR__ . "/database1.php";
session_start();


//$txtt=$_POST['txt1']=print_r($_SESSION);

//verifyer
if(isset($_SESSION["user_id"])){
    
    

    $mysqli = require __DIR__ . "/database1.php";
    
    $sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
      
  //user name
    
  
    $result=mysqli_query($mysqli,$sql);

	$row=mysqli_fetch_assoc($result);

	$cur_rec=$row['user_in'];//curent user
	$usermail=$row['user_email'];//user email

	$namu=$row['user_n'];

  //echo ("Hello, ".$cur_rec);//display current user
}




//to get user information
$id=$_SESSION['user_id'];

//display data
$sql="SELECT * FROM medrec_userd WHERE user_curr='$id'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_assoc($result);
//if the record is null
if($row==null){
  $username="N/A";
  $userem="N/A";
  $edad="N/A";
  $birth_d="N/A";
  $use_h="N/A";
  $use_w="N/A";
  $user_sx="N/A";
  $use_bld="N/A";
  $prescipt="N/A";
  $sign_img="N/A";
  $dr_pres="N/A";
}else{
  $username=$row['user_namu'];
  $userem=$row['email_user'];
  $edad=$row['user_age'];
  $birth_d=$row['user_birthday'];
  $use_h=$row['user_height'];
  $use_w=$row['user_weight'];
  $user_sx=$row['user_gend'];
  $use_bld=$row['user_bloodt'];
  $prescipt=$row['prescript'];
  $dr_pres=$row['name_dr'];
  //for image
  $sign_img=$row["img_sg"];
  $sign_img="<img src='doctor_sign/$sign_img' width='200' height='100'/>";
}




$sqli="SELECT * FROM medrec_personal WHERE user_curr='$id'";
$result2=mysqli_query($mysqli,$sqli);
$row2=mysqli_fetch_assoc($result2);

//if the record is null
if($row2==null){
  $user_vc="N/A";
  $user_mnl="N/A";
  $mnl_lsf="N/A";
  $mnl_ls="N/A";
  $fam_il="N/A";
  $prev_il="N/A";
  $cv_1st="N/A";
  $cv_1dt="N/A";
  $cv_2nd="N/A";
  $cv_2dt="N/A";
  $bs_vc="N/A";
  $bs_dt="N/A";
}else{
  $user_vc=$row2['user_vices'];
  $user_mnl=$row2['first_menstrual'];
  $mnl_lsf=$row2['lastin_for'];
  $mnl_ls=$row2['last_menstrual'];
  $fam_il=$row2['family_history'];
  $prev_il=$row2['previous_ill'];
  $cv_1st=$row2['first_cvaccine'];
  $cv_1dt=$row2['first_cdate'];
  $cv_2nd=$row2['second_cvaccine'];
  $cv_2dt=$row2['second_cdate'];
  $bs_vc=$row2['booster_cvac'];
  $bs_dt=$row2['booster_cdate'];
}




//require the user to login if not log in
require "logchecker.php";


?>


<!DOCTYPE html>

<html>
<head>
  
  <title> Admin Medical Record Page</title>

  <link rel="stylesheet" href="css/style-reg.css">
  <meta charset="utf-8">
</head>
<body>
    
    
    
   <div class ='container'>
  <div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
    <h1> User Medical Record</h1>
  </div>



<a href="process-userp.php"><button type="button"class="to_btn">Back</button></a>
  
<!-- General Data tab -->

<div id="settings" class="tabcontent" style="display:block">
  <h3>User General Data</h3>

  
  <form method="post">

    <label for="Text">Full Name: </label>
    <br>
    <h3>
    <?php //user name

     echo($username)    ?>
    </h3>
    <br>
    
    <label for="Text">Email: </label>
    <br>
    
    <h3>
    <?php //user email

     echo($userem)    ?>
    </h3>
    <br>
    
    <label for="Text">Age: </label>
  <h3>
    <?php //user name

     echo($edad)    ?>
    </h3>
    <br>

  <label for="Text">Birthday: </label>
  <h3>
    <?php //user name

     echo($birth_d)    ?>
    </h3>
    <br>

  <label for="Text">Height: </label>
  <h3>
    <?php //user name

     echo($use_h)    ?>
    </h3>
    <br>

  <label for="Text">Weight: </label>
  <h3>
    <?php //user name

     echo($use_w)    ?>
    </h3>
    <br>

<label for="Text">Gender(sex): </label>
<h3>
    <?php //user name

     echo($user_sx)    ?>
    </h3>
    <br>


<br>

  <label for="Text">Blood Type: </label>
  <h3>
    <?php //user name

     echo($use_bld)    ?>
    </h3>
    <br>


  
  </form>
</div>

<!-- medical Data tab -->
<div id="settings" class="tabcontent" style="display:block">
  <h3>User Personnal Medical Data</h3>

  
  <form method="post">


    <label for="Text">User Vices: </label>

    <h3>
    <?php //user name

     echo($user_vc)    ?>
    </h3>
    <br>

    <h3>Menstrual (For Female)</h3>

    <label for="Text">First menstrual Age: </label>
    <h3>
    <?php //user name

     echo($user_mnl)    ?>
    </h3>
    <br>

    <label for="Text">Lasting for: </label>
    <h3>
    <?php //user name

     echo($mnl_lsf)    ?>
    </h3>
    <br>
    <label for="Text">Last menstrual date: </label>
    <h3>
    <?php //user name

     echo($mnl_ls)    ?>
    </h3>
    <br>

    <h3>Family History</h3>

    <label for="Text">Family history Disease: </label>
    <h3>
    <?php //user name

     echo($fam_il)    ?>
    </h3>
    <br>

    <h3>Previous Illness</h3>

    <label for="Text">Enter previous illness: </label>
    <h3>
    <?php //user name

     echo($prev_il)    ?>
    </h3>
    <br>

    <h3>Covid Vaccination</h3>

    <label for="Text">First dose vaccine name: </label>
    <h3>
    <?php //user name

     echo($cv_1st)    ?>
    </h3>
    <br>
    <label for="Text">Date of first dose: </label>
    <h3>
    <?php //user name

     echo($cv_1dt)    ?>
    </h3>
    <br>
     <label for="Text">Second dose vaccine name: </label>
    <h3>
    <?php //user name

     echo($cv_2nd)    ?>
    </h3>
    <br>
    <label for="Text">Date of Second dose: </label>
    <h3>
    <?php //user name

     echo($cv_2dt)    ?>
    </h3>
    <br>

    <label for="Text">Booster vaccine name: </label>
    <h3>
    <?php //user name

     echo($bs_vc)    ?>
    </h3>
    <br>
    <label for="Text">Date of Booster dose: </label>
    <h3>
    <?php //user name

     echo($bs_dt)    ?>
    </h3>
    <br>

  <br>

  
  </form>
</div>

<!-- presciption tab -->
<div id="settings" class="tabcontent" style="display:block">
  <h3>User Precription</h3>
  <form method="post">
    <label for="Text">User Prescription</label>
    <h3>
      <?php echo($prescipt) ?>
        
      </h3>
     
     <?php echo($sign_img) ?>
    
     <h3>
         _____________________
         <br>
         <?php echo($dr_pres) ?>
   
     </h3>
  <br>
  <br>
  

  </form>
</div>



</body>
</html>