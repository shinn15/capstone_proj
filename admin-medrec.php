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




//for search function 
if(isset($_POST['search_but'])){
    $searchI=$_POST['search_n'];
    $data_sqli="SELECT * FROM medrec_userd WHERE CONCAT(user_curr, user_namu, email_user) LIKE '%".$searchI."%'";
    $result_data=mysqli_query($mysqli,$data_sqli);
}else{
    $data_sqli="SELECT * FROM medrec_userd";
    $result_data=searchItem($data_sqli);
}

//extract data
function searchItem($data_sqli){
    $mysqli = require __DIR__ . "/database1.php";
    $searchItem=mysqli_query($mysqli,$data_sqli);
    return $searchItem;
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
        <h2>User Medical Record</h2>
        
<form method="post">
 <!---search --->
 <input type="text" id="search_n" name="search_n" placeholder="search name or userID">
 <button type="submit" id="search_but" name="search_but">Search</button>
</form>
<!---end search--->
<div id="inventory" style="overflow-x:auto;">
		<table>

			<thead id="row_n">
			<tr>
				<th id="row_n"> Time Recorded: </th>
				<th id="row_n"> User Id: </th>
				<th id="row_n"> User Name: </th>
				<th id="row_n"> User email: </th>
				<th id="row_n"> Edit/View: </th>
				<th id="row_n"> Delete: </th>
				

			</tr>
			</thead>
			<br>

			<tbody>
				<?php
			
					while($row=mysqli_fetch_assoc($result_data)){
						//$idd=$row['id'];
						$orass=$row['time_ed'];
						$userid=$row['user_curr'];
						$usename=$row['user_namu'];
						$userm=$row['email_user'];
						
						//show inventory information
						//id is for easily locate object
						$table_data="
						<tr>
							<td> $orass </td>
							<td> $userid </td>
							<td> $usename </td>
							<td> $userm  </td>
							<td>
							<a href='admin-medrec2.php?user_idd=$userid'><button>Edit/View</button></a>
							</td>
							<td>
							<a href='admin-meddel.php?del_idd=$userid'><button>Delete</button></a>
							</td>
						</tr>";
						
                            echo($table_data);
                		}
			    	
				?>
			</tbody>


		</table>
<br>
</div>
<a href="admin-page.php"><button>Back</button></a>
<a href="admin-admedrec.php"><button>Add Record</button></a>





</div>
</div>
</body>
</html>