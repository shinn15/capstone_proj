<?php

//database1 file
$mysqli=require __DIR__ . "/database1.php";

//for email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
//error_reporting(0); ignore error";


//userid
//studentno = username

//check student full name
if (strlen($_POST['f_name']) < 7 ){
    //display the error and redirect
   $alert1="<script>alert('Invalid Full Name!'); window.location.href='register_1.html'</script>";
   die($alert1);

}

if (strlen($_POST['userm']) < 5 ){
   //display the error and redirect
   $alert1="<script>alert('User name should be 5+ character!'); window.location.href='register_1.html'</script>";
   die($alert1);

}

//for email
$checkem = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
if ( ! preg_match($checkem, $_POST['usereml'])){

  $alert1 ="<script>alert('Invalid Email!'); window.location.href='register_1.html'</script>";
   die($alert1);

}

//check if email alredy used
$imal=$_POST['usereml'];
    
$ch_query="SELECT * FROM login_db WHERE user_email ='$imal'";
$result=mysqli_query($mysqli,$ch_query);
$row=mysqli_fetch_assoc($result);
    
$chk_m=$row['user_email'];
if($chk_m==$imal){
    
    $alert1 ="<script>alert('Email already used!'); window.location.href='register_1.html'</script>";
    die($alert1);
}


//password security

if (strlen($_POST['passwordr']) < 8 ){

   $alert1 = "<script>alert('Password must be at least 8 characters!'); window.location.href='register_1.html'</script>";
   die($alert1);
   //die("Password must be at least 8 characters!");
   }

if ( ! preg_match("/[a-z]/i", $_POST['passwordr'])){

   $alert1="<script>alert('Password must contain letter!'); window.location.href='register_1.html'</script>";
   die($alert1);
   //die("Password must contain letter!");

   }

if ( ! preg_match("/[0-9]/", $_POST['passwordr'])){
   $alert1 ="<script>alert('Password must contain one number!'); window.location.href='register_1.html'</script>";
   die($alert1);
   //die("Password must contain one number!");
   }


if ($_POST['passwordr'] !== $_POST['confirm_pass']){
   $alert1 = "<script>alert('Password must match!'); window.location.href='register_1.html'</script>";
   die($alert1);
   //die("Password must match");


   }

//
$usermail=$_POST['usereml'];

//email verifier code
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
            
$mail->addAddress($usermail);//user email
            
$mail->isHTML(true);
            
            //
$ver2_code=substr(number_format(time() * rand(),0,'',''), 0 , 6);
            
$mail->Subject ="New User email verification code";
$mail->Body='<p>Your Email Verification code:<b style="font-size:30px;"> ' . $ver2_code . '</b></p>';
            
$mail->send();
            
//secure the pas
$pass_hash=password_hash($_POST['passwordr'], PASSWORD_DEFAULT);
//authority
$autho='user';
//verifyer email
$veri="Not_Verified";

$username=$_POST['f_name'];
$userid=$_POST['userm'];

$time_td=date("Y-m-d");

//insert into table database
$sql="INSERT INTO login_db(date_update,user_n,auth,user_email,ver_code,verified_email,user_in,password_hash)
                  VALUES ('$time_td','$username','$autho','$usermail','$ver2_code','$veri','$userid','$pass_hash')";
                  
$result=mysqli_query($mysqli,$sql);

//check if account already taken and Register account
if ($result){

   //transfer to next page if register i sucessfull!
   //die "Register successsful!";
   //header("Location: user_succes.html");
   $alert102 = "<script>alert('Account successsfuliy created, Email Verification code send!'); window.location.href='index.php'</script>";
   die($alert102);
   exit;

}else{

   if($mysqli -> errno === 1062){
      $alert101 = "<script>alert('Account Already Taken!'); window.location.href='register_1.html'</script>";
      die($alert101);
   }else{

      die($mysqli -> error . " " . $mysqli -> errno);
   }  
}



//print_r($_POST);
//var_dump($pass_hash);

?>

