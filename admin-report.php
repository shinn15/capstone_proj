<?php

session_start();

$mysqli = require __DIR__ . "/database1.php";

//get current user id
if(isset($_SESSION["user_id"])){

		
		//get current user name

		$sql = "SELECT * FROM login_db WHERE user_in = '{$_SESSION['user_id']}'";
	
		$result=mysqli_query($mysqli,$sql);

		//$row=mysqli_fetch_assoc($result);
    
	}

//concat for to maxsh the array sql row
//for search function 
if(isset($_POST['search_but'])){
    $searchI=$_POST['search_n'];
    $data_sqli="SELECT * FROM login_db WHERE CONCAT(user_n, user_email, user_in,user_status) LIKE '%".$searchI."%'";
    $result_data=searchItem($data_sqli);
    
}else{
    $data_sqli="SELECT * FROM login_db";
    $result_data=searchItem($data_sqli);
}

//extract data
function searchItem($data_sqli){
    $mysqli = require __DIR__ . "/database1.php";
    $searchItem=mysqli_query($mysqli,$data_sqli);
    return $searchItem;
}














//needed pie chart for online user

//require the user to login if not log in
require "logchecker.php";

?>

<!DOCTYPE html>

<html>
<head>
	
	<title>Online Clinic Report Module</title>
	<link rel="stylesheet" type="text/css" href="css/style-report.css"> 
	<meta charset="utf-8">
	

	
</head>

<body>

  
<div class="admin-profile">
        <h2>User Record</h2>
 
<form method="post">
 <!---search --->
 <input type="text" id="search_n" name="search_n" placeholder="search email or userID">
 <button type="submit" id="search_but" name="search_but">Search</button>
</form>

<div id="inventory" style="overflow-x:auto;">
		<table>
			<br>
			<thead id="row_n">
			<tr>
			    <th id="row_n"> Account use in: </th>
				<th id="row_n"> User name: </th>
				<th id="row_n"> User Id: </th>
				<th id="row_n"> User email: </th>
				<th id="row_n"> Status: </th>
				<th id="row_n"> Edit: </th>
				<th id="row_n"> Delete: </th>


			</tr>
			</thead>
			<br>

			<tbody>
				<?php
				//extract record information
				while($row=mysqli_fetch_assoc($result_data)){

						$idd=$row['id_no'];
						$date_up=$row['date_update'];
						$usname=$row['user_n'];
						$userid=$row['user_in'];
						$userm=$row['user_email'];
						$us_status=$row['user_status'];
						
						//show inventory information
						//id is for easily locate object
						$table_data="
						<tr>
						    <td> $date_up </td>
							<td> $usname </td>
							<td> $userid </td>
							<td> $userm </td>
							<td> $us_status </td>
							<td><a href='admin-redit.php?edt_id=$idd'><button>Edit</button></a></td>
							<td> 
							<a href='admin-rdel.php?del_id=$idd'><button>Delete</button></a>
							</td>
							
						</tr>";


						echo($table_data);

					}
				

				?>
			</tbody>


		</table>
<br>

</div>
<a href="admin-accadd.php"><button>Add Account</button></a>
<a href="admin-page.php"><button type="button"class="to_btn">Back</button></a>
</div>

    
</body>
</html>