<?php

session_start();


//$txtt=$_POST['txt1']=print_r($_SESSION);

//verifyer
if(isset($_SESSION["user_id"])){

	$mysqli = require __DIR__ . "/database1.php";

	$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
	//user name
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();

	//echo ("Hello, ".$_SESSION['user_id']);//display current user
}



$mysqli=require __DIR__ . "/database1.php";

//to get user information
$id=$_GET['user_idd'];

//display data
$sql="SELECT * FROM medrec_userd WHERE user_curr='$id'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_assoc($result);
//if the record is null
if($row==null){
	$username="N/A";
	$edad="N/A";
	$birth_d="N/A";
	$use_h="N/A";
	$use_w="N/A";
	$user_sx="N/A";
	$use_bld="N/A";
	$prescipty="N/A";
	$doctor_pr="N/A";
	$sign_dr="N/A";
}else{
	$username=$row['user_namu'];
	$edad=$row['user_age'];
	$birth_d=$row['user_birthday'];
	$use_h=$row['user_height'];
	$use_w=$row['user_weight'];
	$user_sx=$row['user_gend'];
	$use_bld=$row['user_bloodt'];
	$prescipty=$row['prescript'];
	$doctor_pr=$row['name_dr'];
	$sign_dr=$row['img_sg'];
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




//medrec userd
if(isset($_POST['submit_udat'])){
        
    $oras=date("Y-m-d");
    $username=$_POST['name_u'];
	$userage=$_POST['ua_u'];
	$userbd=$_POST['u_btd'];
	$userh=$_POST['us_h'];
	$userw=$_POST['us_w'];
	$user_s=$_POST['us_sx'];
	$userbld=$_POST['us_by'];

	//check if age is = to number
 	if(!preg_match("/[0-9]/",$_POST['ua_u'])){

	 	//display the error and redirect
	  $alert1="<script>alert('age must contain number!'); window.location.href='admin-medrec2.php'</script>";
	  die($alert1);

 	}
//check age
// || = and
 	if(strlen($_POST['ua_u']) < 2 || strlen($_POST['ua_u']) > 2){
	//display the error and redirect
	  $alert1="<script>alert('please enter legal age!'); window.location.href='admin-medrec2.php'</script>";
	  die($alert1);

		}

//check height and weight
	if(!preg_match("/[0-9]/",$_POST['us_h'],$_POST['us_w'])){

	 	//display the error and redirect
	  $alert1="<script>alert('height and weight must contain number!'); window.location.href='admin-medrec2.php'</script>";
	  die($alert1);

 	}

		//insertin data into database

	$sqli="UPDATE medrec_userd SET time_ed='$oras',user_namu='$username',user_age='$userage',user_birthday='$userbd',user_height='$userh',user_weight='$userw',user_gend='$user_s',user_bloodt='$userbld' WHERE user_curr='$id'";

	$result=mysqli_query($mysqli,$sqli);

	 $alert1="<script>alert('User Data Recorded Updated successfully'); window.location.href='admin-medrec.php'</script>";


	 if($result){
    	echo($alert1);
    }else{
    	$error_d=$mysqli -> connect_errno;
    	$alert2="<script>alert('Connection error:'); window.location.href='admin-medrec.php'</script>".$error_d;
    	echo($alert2);
    	}


}


//user peronal record
if(isset($_POST['submit_pud'])){

	$uvice_ot=$_POST['u_vic'];

	$f_menst=$_POST['mens_a'];
	$ls_menst=$_POST['lsf'];
	$lt_menst=$_POST['ls_mens'];

	$fam_il=$_POST['fm_h'];

	$prev_il=$_POST['prev_i'];

	$f_vac=$_POST['fvac_n'];
	$f_vacd=$_POST['f_vac'];

	$s_vac=$_POST['svac_n'];
	$s_vacd=$_POST['s_vac'];

	$b_vac=$_POST['bsvac_n'];
	$b_vacd=$_POST['bs_vac'];
    
    $oras=date("Y-m-d");
       
	//insertin data into database
	
	//check if the user have dont already record
    $sql2="SELECT * FROM medrec_personal WHERE user_curr='$id'";
    $result2=mysqli_query($mysqli,$sql2);
    $row2=mysqli_fetch_assoc($result2);
    
    $chck=$row2['user_curr']==$id;
    //@ to ignore error msg
    if(@$chck==null){
        
        
    	$sqli="INSERT INTO medrec_personal (user_curr,user_vices,first_menstrual,lastin_for,last_menstrual,
														family_history,previous_ill,first_cvaccine,first_cdate,second_cvaccine,
														second_cdate,booster_cvac,booster_cdate)
											VALUES('$id','$uvice_ot','$f_menst','$ls_menst','$lt_menst','$fam_il','$prev_il',
										'$f_vac','$f_vacd','$s_vac','$s_vacd','$b_vac','$b_vacd')";

    	$result=mysqli_query($mysqli,$sqli);
    
    	$alert1="<script>alert('User Data Recorded Updated successfully'); window.location.href='admin-medrec.php'</script>";
    
    
    	 if($result){
        	echo($alert1);
        }else{
        	$error_d=$mysqli -> connect_errno;
        	$alert2="<script>alert('Connection error:'); window.location.href='admin-medrec.php'</script>".$error_d;
        	echo($alert2);
        	}
        //else if it's not null
        }else{
            
	
        	$sqli="UPDATE medrec_personal SET user_vices='$uvice_ot',first_menstrual='$f_menst',lastin_for='$ls_menst',last_menstrual='$lt_menst',family_history='$fam_il',previous_ill='$prev_il',first_cvaccine='$f_vac',first_cdate='$f_vacd',second_cvaccine='$s_vac',second_cdate='$s_vacd',booster_cvac='$b_vac',booster_cdate='$b_vacd' WHERE user_curr='$id'";
        
        	$result=mysqli_query($mysqli,$sqli);
        
        	 $alert10="<script>alert('User Data Recorded Updated successfully'); window.location.href='admin-medrec.php'</script>";
        
        
        	 if($result){
            	echo($alert10);
            }else{
            	$error_d=$mysqli -> connect_errno;
            	$alert20="<script>alert('Connection error:'); window.location.href='admin-medrec.php'</script>".$error_d;
            	echo($alert20);
            	}


    }



}


//user presciption record
if(isset($_POST['pres_b'])){

	$prescip=$_POST['pressc'];
    $oras=date("Y-m-d");
    $dr_pres=$_POST['pres_dr'];
   //$nm_fl=$_POST['nm_fl'];//img name
   
   //for uploading img
    $image=$_POST['img_fl'];//img file


    $img_name= $_FILES['img_fl']['name'];
    $img_sz= $_FILES['img_fl']['size'];
    $img_tmp= $_FILES['img_fl']['tmp_name'];
    
    //50kb allowed
    if($img_sz > 50000){
            echo "<script>alert('File is to large');</script>";
        
    }else{
        $img_ext= pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc=strtolower($img_ext);
        
        $allowed_file=array("jpg", "jpeg", "png");
        
        //check file
        if(in_array($img_ex_lc, $allowed_file)){
            //edit and upload file
            $new_img_name=uniqid("IMG-",true). '.' .$img_ex_lc;
            $img_file='doctor_sign/'. $new_img_name;
            move_uploaded_file($img_tmp,$img_file);
            
            //insert to database
            $sqli="UPDATE medrec_userd SET time_ed='$oras', prescript='$prescip',name_dr='$dr_pres' ,img_sg='$new_img_name' WHERE user_curr='$id' ";

	        $result=mysqli_query($mysqli,$sqli);
            
	        echo "<script>alert('User prescription Recorded successfully'); window.location.href='admin-medrec.php'</script>";

        }else{
            echo "<script>alert('Invalid file');</script>";
        }
        
    }

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



<a href="admin-medrec.php"><button type="button"class="to_btn">Back</button></a>
	
<!-- General Data tab -->

<div id="settings" class="tabcontent" style="display:block">
  <h3>User General Data</h3>

  
  <form method="post">

  	<label for="Text">Full Name: </label>
  	<input type="Text" class="input_box" placeholder="User name: " id="name_u" name="name_u"  value=<?php echo($username);?>>

  	<label for="Text">Age: </label>
	<input type="Text" class="input_box" placeholder="User Age: " id="ua_u" name="ua_u"  value=<?php echo($edad);?>>

	<label for="Text">Birthday: </label>
	<input type="Text" class="input_box" placeholder="User Birthday: " id="u_btd" name="u_btd" value=<?php echo($birth_d);?>>

	<label for="Text">Height: </label>
	<input type="Text" class="input_box" placeholder="User Height in cm: " id="us_h" name="us_h" value=<?php echo($use_h);?> >

	<label for="Text">Weight: </label>
	<input type="Text" class="input_box" placeholder="User Weight in cm: " id="us_w" name="us_w" value=<?php echo($use_w);?>>

<label for="Text">Gender(sex): </label>
<input type="Text" class="input_box" placeholder="User Gender(sex): " id="us_sx" name="us_sx" value=<?php echo($user_sx);?>>


<br>

	<label for="Text">Blood Type: </label>
	<input type="Text" class="input_box" placeholder="Blood Type: " id="us_by" name="us_by" value=<?php echo($use_bld);?>>


	<button type="submit" id="submit_udat" name="submit_udat">Enter Record</button>

	
	</form>
</div>



<!-- medical Personal Data tab -->
<div id="settings" class="tabcontent" style="display:block">
  <h3>User Personnal Medical Data</h3>

  
  <form method="post">

  	<h3>Personnal vice</h3>

  	<label for="Text">User Vices: </label>

  	<input type="Text" placeholder="Other Vices: " class="input_box" id="u_vic" name="u_vic" value=<?php echo($user_vc);?>>

  	<h3>Menstrual (For Female)</h3>

 		<label for="Text">First menstrual Age: </label>
  	<input type="Text" placeholder="First menstrual Age: " class="input_box"  id="mens_a" name="mens_a" value=<?php echo($user_mnl);?>>

  	<label for="Text">Lasting for: </label>
  	<input type="Text" placeholder="Lasting for(date): " class="input_box"  id="lsf" name="lsf" value=<?php echo($mnl_lsf);?>>

  	<label for="Text">Last menstrual date: </label>
  	<input type="Text" placeholder="Recent menstrual date: " class="input_box"  id="ls_mens" name="ls_mens" value=<?php echo($mnl_ls);?>>

  	<h3>Family History</h3>

  	<label for="Text">Family history Disease: </label>
  	<input type="Text" placeholder="Family history Disease: " class="input_box"  id="fm_h" name="fm_h" value=<?php echo($fam_il);?>>

  	<h3>Previous Illness</h3>

  	<label for="Text">Enter previous illness: </label>
  	<input type="Text" placeholder="previous illness: " class="input_box"  id="prev_i" name="prev_i" value=<?php echo($prev_il);?>>

  	<h3>Covid Vaccination</h3>

  	<label for="Text">First dose vaccine name: </label>
  	<input type="Text" placeholder="First dose vaccine name: " class="input_box"  id="fvac_n" name="fvac_n" value=<?php echo($cv_1st);?>>
  	<label for="Text">Date of first dose: </label>
  	<input type="Text" placeholder="Date of first dose: "  class="input_box"  id="f_vac" name="f_vac" value=<?php echo($cv_1dt);?> >

  	 <label for="Text">Second dose vaccine name: </label>
  	<input type="Text" placeholder="Second dose vaccine name: " class="input_box"  id="svac_n" name="svac_n" value=<?php echo($cv_2nd);?>>
  	<label for="Text">Date of Second dose: </label>
  	<input type="Text" placeholder="Date of Second dose: " class="input_box"  id="s_vac" name="s_vac" value=<?php echo($cv_2dt);?> >

  	<label for="Text">Booster vaccine name: </label>
  	<input type="Text" placeholder="Booster vaccine name: " class="input_box"  id="bsvac_n" name="bsvac_n" value=<?php echo($bs_vc);?> >
  	<label for="Text">Date of Booster dose: </label>
  	<input type="Text" placeholder="Date of Booster dose: " class="input_box"  id="bs_vac" name="bs_vac" value=<?php echo($bs_dt);?>>

  <br>
  <br>
	<button type="submit" id="submit_pud" name="submit_pud">Enter Record</button>

	
	</form>
</div>

<!-- presciption tab -->
<div id="settings" class="tabcontent" style="display:block">
  <h3>User Precription</h3> 
  <p>*only 50kb allowed</p>
  <form method="POST" enctype="multipart/form-data">
  	<label for="Text">User Prescription</label>
  	<input type="Text" placeholder="Presciption" class="input_box" id="pressc" name="pressc" value=<?php echo($prescipty) ?>>
  	<label for="Text">Doctor name</label>
  	<input type="Text" placeholder="Doctor Name" class="input_box" id="pres_dr" name="pres_dr" value=<?php echo($doctor_pr); ?>>
   <br>
    <br>
    <label>Prescription Doctor Sign:</label><br>
    <br>
  	 <label for="img_fl">image sign:</label>
  	
  	 <br>
  	<input type="file" id="img_fl" name="img_fl" accept=".jpg, .jpeg, .png" value=<?php echo($sign_dr); ?>> 
  	<br>
  	<br>
  <button type="submit" id="pres_b" name="pres_b">Enter Record</button>

  </form>
</div>



</body>
</html>