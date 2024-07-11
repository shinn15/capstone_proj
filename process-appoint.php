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

    //echo ("Hello, ".$_SESSION['user_id']);//display current user
  }


  //echo($cur_rec);


/*
//for month
$prev_b=isset($_POST['prevb']);
$next_b=isset($_POST['nextb']);

$currm=date("F");//cureent month
$curry=date("Y");//current year
$date=date("F Y");

*/

/*auto delete book
$delt="DELETE FROM appoint_db WHERE date_appoint < DATE_SUB(NOW(),INTERVAL 1 DAY)";
$resulta=mysqli_query($mysqli,$delt);
*/

//if the appointment is in date
$smqly="SELECT * FROM appoint_db WHERE user_id='$cur_rec' ";
$resuli=mysqli_query($mysqli,$smqly);
$rowi=mysqli_fetch_assoc($resuli);

$booki_u=$rowi['date_appoint'];

$dateapp=date($rowi['date_appoint']);
$date_today=date("Y-m-d H:i:s");
if($dateapp > $date_today){
    $alert4 ="<script>alert('Already have active appointment!'); window.location.href='process-userp.php'</script>";
    die($alert4);
}


function build_calendar($month, $year,$cur_rec,$namu){

  $mysqli = require __DIR__ . "/database1.php";


  
  
  //week
  $dayweek=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
  //first day of month //$month checker
  $first_day=mktime(0,0,0,$month,1,$year);

  //number of day
  $daysnum=date('t',$first_day);
  //firstday of month
  $datecomp=getdate($first_day);
  //name of the moth year
  $month_n=$datecomp['month'];

  $week_day=$datecomp["wday"];

  $today_d=date('Y-m-d');


  //start calendar table
  $calen="<table class='calen-border'>";
  $calen.="<center><h2>$month_n $year<h2>";


  //back and next month
  $calen.="<a class='buton_m'href='?month=".date('m', mktime(0,0,0,$month-1,1,$year))."&year=".date('Y',mktime(0,0,0, $month-1,1,$year))."' > < </a>";

  $calen.="<a class='buton_m' href='?month=".date('m')."&year=".date('Y')."'> current month </a>";


  $calen.="<a class='buton_m' href='?month=".date('m', mktime(0,0,0, $month+1,1,$year))."&year=".date('Y',mktime(0,0,0, $month+1,1,$year))."'> > </a></center>";


  $calen.="<tr>";
  
  foreach($dayweek as $araw){
    $calen.="<th class='header'>$araw</th>";
  }
  $calen.="</tr><tr>";
  //column tiles for weekdays
  if($week_day>0){
    for($k=0;$k<$week_day;$k++){
      $calen.="<td></td>";

    }
  }


//daysofweek =dayweek
//dayofweek=week_day

  $currday=1;


  $month=str_pad($month,2,"0", STR_PAD_LEFT);

//showing the day and week
  while($currday<=$daysnum){

    if($week_day==7){
      $week_day=0;
      $calen.="</tr><tr>";
    }

    $currdayrel=str_pad($currday,2,"0", STR_PAD_LEFT);

    $dates="$year-$month-$currdayrel";

    //for bookin
      $daynamu=strtolower(date('l',strtotime($dates)));
      $numevent=0;
      $today=$dates==date('Y-m-d')?"today":"c";


    //checkin bookin
     
    //display dates
    //if the clinic is closed
    if($daynamu=='saturday'||$daynamu=='sunday'){
      $calen.="<td><h4>$currday</h4><a class='na_b' href=''>Closed</a>";
    }
    //if the day is today
    elseif($dates==date('Y-m-d')){
      $calen.="<td class=".$today."><h4>$currday</h4><a class='na_b' href=''>N/A</a>";
    }
    
    //if the day already pass
    elseif($dates<date('Y-m-d')){
      $calen.="<td><h4>$currday</h4><a class='na_b' href=''>N/A</a>";
    }
    
    /*if theres already bookin
    elseif($bookin==$dates){
      $calen.="<td class=".$today."><h4>$currday</h4><a class='na_b' href=''>Already Book</a>";
    }
    */
    //for bookin slot and appointment
    else{
      $totalbookin=Checkslot($mysqli,$dates);
      //check the total booking per day
      if($totalbookin==30){
        $calen.="<td class=".$today."><h4>$currday</h4><a class='na_b' href=''>appointment Full</a>";
      }
 
      else{
        $availslot=30 - $totalbookin;
        
        $calen.="<td class=".$today."><h4>$currday</h4><a class='appo_b' href='process-book.php?dates=".$dates." &curid=".$cur_rec." &nameid=".$namu."'>appointment</a><small><i> Availlable appointment is $availslot </i></small>";
      }
    }



    $calen.="</td>";

    //increment 
    $currday++;
    $week_day++;

  }

//complete row
  if($week_day != 7){
    $dayremain=7-$week_day;
    for($i=0; $i<$dayremain; $i++){
      $calen.="<td></td>";
    }
  }


  $calen.="</tr>";
  $calen.="</table>";


  
  echo($calen);


}

//for daily bookin limit
function Checkslot($mysqli,$dates){

  $mysqli = require __DIR__ . "/database1.php";
 
  //if check the appointment
  $appoint=$mysqli->prepare("SELECT * FROM appoint_db WHERE date_appoint=?");
  $appoint->bind_param('s',$dates);
  //book id
  $totalbookin=0;
  

  if($appoint->execute()){
    $result=$appoint->get_result();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $totalbookin++;
      }
      $appoint->close();
    }
  }


  return $totalbookin;


}

//require the user to login if not log in
require "logchecker.php";


?>
<!DOCTYPE html>

<html>
<head>

	<title> Appointment Page</title>

	<link rel="stylesheet" href="css/style-appoint.css">
	<meta charset="utf-8">

</head>


<body>

<br>
<a href="process-userp.php"><button type="submit"class="buto">Back</button></a>
<br>


<form method="post">


  <?php

  $datecomp=getdate();

  //$month = $datecomp['mon'];           
  //$year = $datecomp['year'];


  //loop the month and year in calendar
  if(isset($_GET['month']) && isset($_GET['year'])){
    $month = $_GET['month'];           
    $year = $_GET['year'];
  }else{
    $month = $datecomp['mon'];           
    $year = $datecomp['year'];
  }
  echo(build_calendar($month,$year,$cur_rec,$namu));


   //echo memory_get_usage();

  ?>








</form>
</body>
</html>