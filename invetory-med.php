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
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();

	echo ("Hello, ".$_SESSION['user_id']);//display current user
}

//require the user to login if not log in
require "logchecker.php";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Campus Clinic Admin Page</title>
	<link rel="stylesheet" type="text/css" href="css/style-admin.css">
</head>
<body>
  <div class ='container'>
	<div class="header">
<img src="resource/logo.png" alt="Campus Clinic Logo">
		<h1>Campus Clinic Admin Page</h1>
	</div>
<div class="admin-profile">
        <h2>Medicine Inventory Management</h2>



<!--responsive table with scroll-->
	<div id="inventory" style="overflow-x:auto;">
		<table>
			<br>
			<thead id="row_n">
			<tr>
				<th id="row_n"> Date Edited: </th>
				<th id="row_n"> Item id: </th>
				<th id="row_n"> Item name: </th>
				<th id="row_n"> Item number: </th>
				<th id="row_n"> Edit: </th>
				<th id="row_n"> Delete: </th>
			</tr>
			</thead>
			<br>

			<tbody>
				<?php
				//extract inventory information
				$sql="SELECT * FROM medinventory_db";
				$result=mysqli_query($mysqli,$sql);
				if($result){
					while($row=mysqli_fetch_assoc($result)){

						$id=$row['id_no'];
						$oras=$row['e_time'];
						$itemid=$row['id_item'];
						$itemname=$row['name_item'];
						$itemnum=$row['num_item'];

						//show inventory information
						//id is for easily locate object
						$table_data="
						<tr>
							<td> $oras </td>
							<td> $itemid </td>
							<td> $itemname </td>
							<td> $itemnum </td>
							<td>
							<a href='admin-medrec2.php?update_id=$id'><button>Update</button></a>
							</td>

							<td>
							<a href='med-delete.php?del_id=$id'><button>Delete</button></a>
							</td>
							</td>
						</tr>";


						echo($table_data);

					}
				}

				?>
			</tbody>


		</table>
<br>
<a href="admin-p2.php"><button>Back</button></a>
<a href="med-create.php"><button>Add Medicine</button></a>

</div>


</div>


</body>
</html>
