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

}



//for search function 
if(isset($_POST['search_but'])){
    $searchI=$_POST['search_n'];
    $data_sqli="SELECT * FROM inventory_db WHERE CONCAT(expire_t ,item_id, item_name, item_num) LIKE '%".$searchI."%'";
    $result_data=searchItem($data_sqli);
    
}else{
    $data_sqli="SELECT * FROM inventory_db";
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
	<title>Campus Clinic Admin Page</title>
	<link rel="stylesheet" type="text/css" href="css/style-admin.css">
</head>
<body>
  <div class ='container'>
	<div class="header">
<img src="resource/logo.jpg" alt="Campus Clinic Logo">
		<h1>Online Clinic Admin Page</h1>
	</div>
<div class="admin-profile">



	<!--responsive table with scroll-->
	<div id="inventory" style="overflow-x:auto;">
		<h2>Item Inventory Management</h2>
		
<form method="post">
 <!---search --->
 <input type="text" id="search_n" name="search_n" placeholder="search">
 <button type="submit" id="search_but" name="search_but">Search</button>
 </form>

		<table>
			<br>
			<thead id="row_n">
			<tr>
				<th id="row_n"> Date Added: </th>
				<th id="row_n"> Expiration Date: </th>
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
					while($row=mysqli_fetch_assoc($result_data)){

						$id=$row['id_no'];
						$oras=$row['time_e'];
						$expr_t=$row['expire_t'];
						$itemid=$row['item_id'];
						$itemname=$row['item_name'];
						$itemnum=$row['item_num'];

						//show inventory information
						//id is for easily locate object
						$table_data="
						<tr>
							<td> $oras </td>
							<td>$expr_t</td>
							<td> $itemid </td>
							<td> $itemname </td>
							<td> $itemnum </td>
							<td>
							<a id='upd' name='upd' href='inventory-update.php?update_id=$id'><button>Update</button></a>
							</td>

							<td>
							<a href='inventory-delete.php?del_id=$id'><button>Delete</button></a>
							</td>
							
						</tr>";


					    echo($table_data);

					}
				

				?>
			</tbody>

		</table>
		<br>
	


	</div>

		 

</div>
	<a href="inventory-create.php"><button>Add Item</button></a>
	<a href="admin-page.php"><button>Back</button></a>

</body>
</html>
