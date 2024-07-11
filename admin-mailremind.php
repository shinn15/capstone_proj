<?php

session_start();


$mysqli = require __DIR__ . "/database1.php";

//verifyer
if(isset($_SESSION["user_id"])){

	$mysqli = require __DIR__ . "/database1.php";

	$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
	//user name
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();

	//echo ("Hello, ".$_SESSION['user_id']);//display current user
}
//require the user to login if not log in
require "logchecker.php";

$usr_eml=$_GET['user_eml'];//user mail


//for email sender
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['eml_send'])){
    
    
    //sender admin
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
    
    $mail->addAddress($usr_eml);//user email
    
    $mail->isHTML(true);
    
    $mail->Subject ="Online Clinic Appointment Reminder";
    $mail->Body=$_POST['adm_msg'];
    
    $mail->send();
    
    echo("<script>alert('Email Send'); window.location.href='admin-sched.php'</script>");
    
    
    
}


//automatic reminder
$todayy=date('Y-m-d');//date today

$dte_sql="SELECT * FROM appoint_db WHERE date_appoint = '$todayy' ";
$result=mysqli_query($mysqli,$dte_sql);
//$row=mysqli_fetch_assoc($result);


while($row=mysqli_fetch_assoc($result)){
    
    $daayt=$row['date_appoint'];

    $eml_us=$row['user_mail'];//users mail
    
    $texto="<p>Hello User,<br>
                It seem you have Appointment Today in Clinic see you there :)<p>";
    
    
    //echo($daayt);
    if($daayt==$todayy){
        
        //sender admin
        $mail2 = new PHPMailer(true);
        
        $mail2->isSMTP();
        $mail2->Host= 'smtp.gmail.com';
        $mail2->SMTPAuth = true;
        $mail2->Username='grouphcapstone072@gmail.com';//sender email
        $mail2->Password='pnyj dyes oyep odmm';//app password gmail
        $mail2->SMTPSecure='ssl';
        $mail2->Port=465;
        
        //user receiver
        $mail2->setFrom('grouphcapstone072@gmail.com');
        
        $mail2->addAddress($eml_us);//user email
        
        $mail2->isHTML(true);
        
        $mail2->Subject ="Online Clinic Appointment Reminder";
        $mail2->Body=$texto;
        
        $mail2->send();
            
    }
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Email User Page</title>

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
          <h2>Email User</h2>
      </div>

		<div class="box_form">
			<div class="button_box">

			

					<form method="post">

					
	                    <label for="Text">Email:</label><br>
						<?php echo($usr_eml);  ?>
						<br>
						<br>
                        <label for="Text">Message:</label><br>
						<input type="text" class="input_box" placeholder="Message: " id="adm_msg" name="adm_msg">


						<button type="submit" class="to_btn" id="eml_send" name="eml_send">Send Email</button>
						
						<a href="admin-sched.php"><button type="button"class="to_btn">Back</button></a>
					</form>
				</div>
			</div>
		</div>



</body>
</html>