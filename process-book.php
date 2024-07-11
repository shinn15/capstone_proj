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

    $namu=$row['user_n'];
    
    $curridy=$row['id_no'];
    
    $currmail=$row['user_email'];

    //echo ("Hello, ".$_SESSION['user_id']);//display current user
  }


//echo($cur_rec);
//for email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//gettin date of book
 if(isset($_GET['dates'])){
 	$dates=$_GET['dates'];
 }
//user id
 if(isset($_GET['curid'])){
 	$curid=$_GET['curid'];
 }
//user name
 if(isset($_GET['nameid'])){
 	$nameid=$_GET['nameid'];
 }

//for user email
$ch_query="SELECT * FROM login_db WHERE user_in ='$curid'";
$result2=mysqli_query($mysqli,$ch_query);
$row2=mysqli_fetch_assoc($result2);

$imal=$row2['user_email'];
//echo($imal);

//insert appointment
if(isset($_POST['submit_appoin'])){
	$usern=$nameid;
	$userid=$curid;
	//$idcurr=$curridy;
	$emailu=$currmail;
	$timesl=$_POST['slc'];

	//alert
	if($timesl==$_POST['slc_0']){
		$alert10="<script>alert('Please choose your Timeslot!'); window.location.href='process-appoint.php'</script>";
  		die($alert10);
	}
    
	$sqla="SELECT * FROM appoint_db WHERE user_id='$userid' ";
    $resulta=mysqli_query($mysqli,$sqla);
    $query1 =mysqli_num_rows($resulta);
    


	//$alertms="<div class='hot'>appoint success!</div>";
	$alert1="<script>alert('User appointment successfull!'); window.location.href='process-userp.php'</script>";

    $mail = new PHPMailer(true);
    
    $mail->isSMTP();
    $mail->Host= 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username='grouphcapstone072@gmail.com';//sender email
    $mail->Password='pnyj dyes oyep odmm';//app password gmail
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
                    
                    //user receiver
    $mail->setFrom('grouphcapstone072@gmail.com');
                    
    $mail->addAddress($imal);//user email
                    
    $mail->isHTML(true);
                    
    $mail->Subject ="User Appointment Reminder";
    $mail->Body='<p>Hello, <b>' .$usern. ' </b> You have a appointment in: <b>' .$dates. '</b> at time of <b>' .$timesl. '</b> See you at clinic :) </p>';
                    
    $mail->send();
    
    	//insert to databas
	$sqli="INSERT INTO appoint_db(n_user,user_id,date_appoint,timeslot,user_mail,status_ur) 
			VALUES('$usern','$userid','$dates','$timesl','$emailu','active')";
	$result=mysqli_query($mysqli,$sqli);
	
	if($result){

    	echo($alert1);
    }else{
    	$error_d=$mysqli -> connect_errno;
    	$alert2="<script>alert('Connection error:'); window.location.href='process-appoint.php'</script>".$error_d;
    	echo($alert2);
    	}
    

}







//require the user to login if not log in
require "logchecker.php";


?>

<!DOCTYPE html>

<html>
<head>

	<title> Appointment Page</title>

	<link rel="stylesheet" href="css/style-reg.css">
	<meta charset="utf-8">

</head>
<body>

<br>
<a href="process-appoint.php"><button type="submit"class="buto">Back</button></a>
<br>


<h3>User Appointment Data</h3>

<center><h2>Appointment Date: <?php  echo date('F/d/Y',strtotime($dates)); ?></h2></center>

<form method="post">
	
	 <label for="Text">Name: </label>
	<h3>
  	<?php //user name

  	 echo($nameid)    ?>
  	</h3>

	<label for="Text">Student No: </label>
	<h3>
  	<?php //user id

  	 echo($curid)    ?>
  	</h3>

	<label for="select">Available Timeslot: </label>

		<select id="slc" name="slc" tabindex="1" size="1" style="width: 240px;" required>
		<option id="slc_0" selected value=""></option>
		<option id=" " value="9:30-9:55" >9:30-9:55</option>
		<option id=" " value="10:25-10:55">10:25-10:55</option>
		<option id=" " value="11:00-11:55">11:00-11:55</option>
		<option id=" " value="1:00-1:25">1:00-1:25</option>
		<option id=" " value="1:30-1:55">1:30-1:55</option>
		<option id=" " value="2:00-2:25">2:00-2:25</option>
		<option id=" " value="2:30-2:55">2:30-2:55</option>
		<option id=" " value="2:30-2:55">3:00-3:25</option>
		</select>
	<br>
	<br>


	<button type="submit" id="submit_appoin" name="submit_appoin">Enter Appointment</button>





</form>
</body>



</html>