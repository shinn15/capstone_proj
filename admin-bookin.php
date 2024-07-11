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
//require the user to login if not log in
require "logchecker.php";


?>
<!DOCTYPE html>

<html>
<head>
	
	<title>Campus Clinic Admin Module</title>
	<link rel="stylesheet" type="text/css" href="css/style-admin.css">
	<meta charset="utf-8">
</head>

<body>
    
    <!---to auto refresh the page
   	<script type="text/javascript">
      function table(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
          document.getElementById("inventory").innerHTML = this.responseText;
        }
        xhttp.open("GET", "#");
        xhttp.send();
      }

      setInterval(function(){
        table();
      }, 10000);
   </script>
  --->
    
    
  <div class ='container'>
	<div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
		<h1>Online Clinic Admin Module</h1>
	</div>
<div class="admin-profile">
        <h2>User Booking Record</h2>
 

<div id="inventory" style="overflow-x:auto;">
		<table>
			<br>
			<thead id="row_n">
			<tr>
				<th id="row_n"> User Name: </th>
				<th id="row_n"> User Id: </th>
				<th id="row_n"> User Email: </th>
				<th id="row_n"> Apointmnet date: </th>
				<th id="row_n"> Appointment time: </th>
				<th id="row_n"> Email: </th>

			</tr>
			</thead>
			<br>

			<tbody>
				<?php
				
				//gettin date of book
                if(isset($_GET['dates'])){
                 	$dates=$_GET['dates'];
                    }
				//extract record information
				$sql="SELECT * FROM appoint_db WHERE date_appoint='$dates'";
				$result=mysqli_query($mysqli,$sql);
				if($result){
					while($row=mysqli_fetch_assoc($result)){

						//$idd=$row['id'];
						$usern=$row['n_user'];
						$userid=$row['user_id'];
						$userm=$row['user_mail'];
						$schedd=$row['date_appoint'];
						$oras=$row['timeslot'];
						
						//show inventory information
						//id is for easily locate object
						$table_data="
						<tr>
							<td> $usern </td>
							<td> $userid </td>
							<td> $userm </td>
							<td> $schedd  </td>
							<td> $oras  </td>
							<td><a href='admin-mailremind.php?user_eml=$userm'><button>Email</button></a>
							</td>

						
		
						
						</tr>";


						echo($table_data);

					}
				}

				?>
			</tbody>


		</table>
<br>
<a href="admin-sched.php"><button>Back</button></a>
<a href="#"><button>Add Schedule</button></a>

</div>



</div>
</div>
</body>
</html>