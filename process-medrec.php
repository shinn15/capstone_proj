<?php

session_start();

$mysqli = require __DIR__ . "/database1.php";


//get current user id
if(isset($_SESSION["user_id"])){

		
		//get current user name

		$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
		$result=mysqli_query($mysqli,$sql);

		$row=mysqli_fetch_assoc($result);

		$cur_rec=$row['user_in'];//curent user
		$usermail=$row['user_email'];//user email
		
		$cur_id=$row['id_no'];//curent user

		$namu=$row['user_n'];

    //echo ("Hello, ".$_SESSION['user_id']);//display current user
	}



//check if the user have already record
$sql2="SELECT * FROM medrec_userd WHERE id='$cur_id'";
$result2=mysqli_query($mysqli,$sql2);
$row2=mysqli_fetch_assoc($result2);

//@ to ignore error msg
if(@$row2['id']==$cur_id){
	$alert10="<script>alert('Already have Record! Update Record?'); window.location.href='user-updr.php'</script>";
	die($alert10);

}


//add to user general data databsae
if(isset($_POST['submit_ud'])){
    
    $oras=date("Y-m-d");
    $id_curr=$cur_id;
	$user_rec=$cur_rec;
	$usernamu=$namu;
	$userage=$_POST['ua_u'];
	$userbd=$_POST['u_btd'];
	$userh=$_POST['us_h'];
	$userw=$_POST['us_w'];
	$user_s=$_POST['sx'];
	$userbld=$_POST['blod'];
	$presc="N/A";

//check user input

//check if age is = to number
 	if(!preg_match("/[0-9]/",$_POST['ua_u'])){

	 	//display the error and redirect
	  $alert1="<script>alert('age must contain number!'); window.location.href='process-medrec.php'</script>";
	  die($alert1);

 	}
//check age
// || = and
 	if(strlen($_POST['ua_u']) < 2 || strlen($_POST['ua_u']) > 2){
	//display the error and redirect
	  $alert1="<script>alert('please enter legal age!'); window.location.href='process-medrec.php'</script>";
	  die($alert1);

		}

//check height and weight
	if(!preg_match("/[0-9]/",$_POST['us_h'],$_POST['us_w'])){

	 	//display the error and redirect
	  $alert1="<script>alert('height and weight must contain number!'); window.location.href='process-medrec.php'</script>";
	  die($alert1);

 	}
/*
 	if(strlen($_POST['us_h']) < 3 || strlen($_POST['us_w']) < 3){

	//display the error and redirect
	  $alert1="<script>alert('please enter legal height and weight!'); window.location.href='process-medrec.php'</script>";
	  die($alert1);

		}*/

//check the gender
 if($user_s==$_POST['sex_0']){
 	//display the error and redirect
  $alert1="<script>alert('Please choose your gender!'); window.location.href='process-medrec.php'</script>";
  die($alert1);

 }

//check the bloodtype
 if($userbld==$_POST['blod_0']){
 	//display the error and redirect
  $alert1="<script>alert('Please choose your bloodtype!'); window.location.href='process-medrec.php'</script>";
  die($alert1);

 }



	//insertin data into database

	$sqli="INSERT INTO medrec_userd(id,time_ed,user_curr,user_namu,email_user,user_age,user_birthday,user_height,user_weight,user_gend,user_bloodt,prescript)
												VALUES('$id_curr','$oras','$user_rec','$usernamu','$usermail','$userage','$userbd','$userh','$userw','$user_s','$userbld','$presc')";

	 $result=mysqli_query($mysqli,$sqli);

	  $alert1="<script>alert('User Data Recorded successfully'); window.location.href='process-userp.php'</script>";


	 if($result){
    	echo($alert1);
    }else{
    	$error_d=$mysqli -> connect_errno;
    	$alert2="<script>alert('Connection error:'); window.location.href='process-userp.php'</script>".$error_d;
    	echo($alert2);
    	}

}



//User Personnal Medical Data

if(isset($_POST['submit_md'])){
    
    $id_curr=$cur_id;
	$user_rec=$cur_rec;

	$uvice=$_POST['vcs'];
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

//if the user choose other in vice
if($uvice_ot != null){
	$ssq="UPDATE medrec_personal SET 	user_vices='$uvice_ot' WHERE user_curr='$user_rec' ";
	$result=mysqli_query($mysqli,$ssq);
	};

//insert in da databaae
$sqlii="INSERT INTO medrec_personal(id,user_curr,user_vices,first_menstrual,lastin_for,last_menstrual,
														family_history,previous_ill,first_cvaccine,first_cdate,second_cvaccine,
														second_cdate,booster_cvac,booster_cdate)
						VALUES('$id_curr','$user_rec','$uvice','$f_menst','$ls_menst','$lt_menst','$fam_il','$prev_il',
										'$f_vac','$f_vacd','$s_vac','$s_vacd','$b_vac','$b_vacd')";

$result=mysqli_query($mysqli,$sqlii);

$alert1="<script>alert('User Personnal Medical Data Recorded successfully'); window.location.href='process-userp.php'</script>";


if($result){
    	echo($alert1);
 }else{
  $error_d=$mysqli -> connect_errno;
  $alert2="<script>alert('Connection error:'); window.location.href='process-userp.php'</script>".$error_d;
  echo($alert2);
    	}


}

//require the user to login if not log in
require "logchecker.php";


?>


<!DOCTYPE html>

<html>
<head>
	
	<title> Medical Record Page</title>

	<link rel="stylesheet" href="css/style-reg.css">
	<meta charset="utf-8">
</head>
<body>
	 <div class ='container'>
	<div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
		<h1> User Medical History</h1>
	</div>



<a href="process-userp.php"><button type="button"class="to_btn">Back</button></a>
	
<!-- General Data tab -->

<div id="settings" class="tabcontent" style="display:block">
  <h3>User General Data</h3>
  <p>//Type N/A if you have no information</p>
  	 <p>//Add ',' for date</p>
  
  <form method="post">

  	<label for="Text">Full Name: </label>
  	<br>
  	<h3>
  	<?php //user name

  	 echo($namu)    ?>
  	</h3>
  	<br>

  	

  	<label for="Text">Age: </label>
	<input type="Text" class="input_box" placeholder="User Age: " id="ua_u" name="ua_u" required>

	<label for="date">Birthday: </label>
	<input type="date" class="input_box" placeholder="User Birthday: " id="u_btd" name="u_btd" required>
    <br>
    <br>
	<label for="Text">Height: </label>
	<input type="Text" class="input_box" placeholder="User Height in cm: " id="us_h" name="us_h" required>

	<label for="Text">Weight: </label>
	<input type="Text" class="input_box" placeholder="User Weight in cm: " id="us_w" name="us_w" required>

<label for="select">Gender(sex): </label>

<select id="sx" name="sx" tabindex="1" size="1" style="width: 240px;" required>
		<option id="sex_0" selected value=""></option>
		<option id="sx_m" value="Male" >Male</option>
		<option id="sx_f" value="Female">Female</option>
		<option id="sx_o" value="Others">Others</option>
</select>

<br>
<br>

	<label for="select">Blood Type: </label>
	<select id="blod" name="blod" tabindex="1" size="1" style="width: 240px;" required>
		<option id="blod_0" selected value=""></option>
		<option id="blod1" value="A+">A+</option>
		<option id="blod2" value="A">A</option>
		<option id="blod3" value="B+">B+</option>
		<option id="blod4" value="B">B</option>
		<option id="blod5" value="O+">O+</option>
		<option id="blod6" value="O">O</option>
		<option id="blod7" value="AB+">AB+</option>
		<option id="blod8" value="AB">AB</option>

	</select>
	<br>
	<br>


	<button type="submit" id="submit_ud" name="submit_ud">Enter Record</button>

	
	</form>
</div>

<!-- medical Data tab -->
<div id="settings" class="tabcontent" style="display:block">
  <h3>User Personnal Medical Data</h3>
  <p>//Type N/A if you have no information</p>
  	 <p>//Add ',' for date</p>
  
  <form method="post">

  	<h3>Personnal vice</h3>

  	<label for="select">What is your Vices: </label>

		<select id="vcs" name="vcs" tabindex="1" size="1" style="width: 240px;" required>
		<option id="vcs_0" selected value=""></option>
		<option id=" " value="Alcoholic" >Alcoholic</option>
		<option id=" " value="Smoker">Smoker</option>
		<option id=" " value="N/A">N/A</option>
		</select>
		<br>
		<br>
  	<label for="Text">Others: </label>

  	<input type="Text" placeholder="Other Vices: " class="input_box" id="u_vic" name="u_vic">

  	<h3>Menstrual (For Female)</h3>

 		<label for="Text">First menstrual Age: </label>
  	<input type="Text" placeholder="First menstrual Age: " class="input_box"  id="mens_a" name="mens_a">

  	<label for="Text">Lasting for: </label>
  	<input type="Text" placeholder="Lasting for(date): " class="input_box"  id="lsf" name="lsf">

  	<label for="Text">Last menstrual date: </label>
  	<input type="Text" placeholder="Recent menstrual date: " class="input_box"  id="ls_mens" name="ls_mens">

  	<h3>Family History</h3>

  	<label for="Text">Family history Disease: </label>
  	<input type="Text" placeholder="Family history Disease: " class="input_box"  id="fm_h" name="fm_h">

  	<h3>Previous Illness</h3>

  	<label for="Text">Enter previous illness: </label>
  	<input type="Text" placeholder="previous illness: " class="input_box"  id="prev_i" name="prev_i">

  	<h3>Covid Vaccination</h3>

  	<label for="Text">First dose vaccine name: </label>
  	<input type="Text" placeholder="First dose vaccine name: " class="input_box"  id="fvac_n" name="fvac_n" required>
  	<label for="Text">Date of first dose: </label>
  	<input type="Text" placeholder="Date of first dose: "  class="input_box"  id="f_vac" name="f_vac" required>

  	 <label for="Text">Second dose vaccine name: </label>
  	<input type="Text" placeholder="Second dose vaccine name: " class="input_box"  id="svac_n" name="svac_n" required>
  	<label for="Text">Date of Second dose: </label>
  	<input type="Text" placeholder="Date of Second dose: " class="input_box"  id="s_vac" name="s_vac" required>

  	<label for="Text">Booster vaccine name: </label>
  	<input type="Text" placeholder="Booster vaccine name: " class="input_box"  id="bsvac_n" name="bsvac_n" required>
  	<label for="Text">Date of Booster dose: </label>
  	<input type="Text" placeholder="Date of Booster dose: " class="input_box"  id="bs_vac" name="bs_vac" required>

  <br>
  <br>
	<button type="submit" id="submit_md" name="submit_md">Enter Record</button>

	
	</form>
</div>








</body>
</html>