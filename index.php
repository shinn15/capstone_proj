<?php

//check if the pass is wrong
$is_invalid = false;

$mysqli = require __DIR__ . "/database1.php";
//check if the account is in the database
if ($_SERVER["REQUEST_METHOD"]==="POST"){

	$mysqli = require __DIR__ . "/database1.php";

	//verify student number as login
	$sql=sprintf("SELECT * FROM login_db WHERE user_in = '%s'",
		$mysqli->real_escape_string($_POST["email_l"]));

	$result = $mysqli -> query($sql);

	//$user = $result -> fetch_assoc();

	$row =  mysqli_fetch_array($result);
    
    

	//var_dump($user);
	//exit;

	//account verifyer
	//redirect if admin
	if($row["auth"]=="admin"){
		//verify if the pass is match
		if(password_verify($_POST["pass_l"], $row["password_hash"])){

			//die("Log In Sucessful!");
			session_start();

			//protect 
			session_regenerate_id();

        
			//user indentiy
			$_SESSION['user_id'] = $row["user_in"];
            
            $curadm=$_SESSION['user_id'];
            
            //date login
            $dateup=date("Y-m-d");
			
			//check the user if it's online
			$sqli_up="UPDATE login_db SET date_update='$dateup', user_status ='Online' WHERE user_in = '$curadm'";
			$resulty=mysqli_query($mysqli,$sqli_up);
            
            
			//tranfer to next page
			header("Location: admin-page.php");
			exit;
		}
	}

	//redireect if user
	else if($row["auth"]=="user"){

		if(password_verify($_POST["pass_l"], $row["password_hash"])){

			//die("Log In Sucessful!");
			session_start();

			//protect 
			session_regenerate_id();


			//user indentiy
			$_SESSION['user_id'] = $row["user_in"];
			
			$curuser=$_SESSION['user_id'];
			
			//date login
            $dateup=date("Y-m-d");
            
			//check the user if it's online
			$sqli_up="UPDATE login_db SET date_update='$dateup', user_status = 'Online' WHERE user_in = '$curuser'";
			$resulty=mysqli_query($mysqli,$sqli_up);
			
			//tranfer to next page
			header("Location: process-userp.php");
			exit;
		}

	}

	//catch if the account is null
	else if($row['user_in'] == null){

		//echo "not valid";
		$alert1="<script>alert('Account not found!'); window.location.href='index.php'</script>";
  		die($alert1);
	}
	

 	$is_invalid=true;


}


//$alert1 = $_POST["alertb"]="<script>alert('account invalid!')</script>";
//print($alert1);


?>	

<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>
    <link rel="stylesheet" type="text/css" href="css/style-login.css">
    <style>
      /*for background image*/
    body{
        background-image:url("resource/bgclin.gif");
        background-repeat:no-repeat;
        background-size:cover;
        background-attachment:fixed;
        }
    </style>
</head>

<body>
    
<nav class="navbar">
  <div class="navdiv">
   <div class="welcome"><a href="#">Welcome</a> </div>
   <ul>
   <button onclick="myFunction()">Login/register</button>
   </ul>
   </div>
</nav>
<script>
//unhide
function myFunction() {
  var z = document.getElementById("frontpage");
  var x = document.getElementById("container");
  if (x.style.display === "none") {
    z.style.display = "none";
    x.style.display = "block";
  } else {
    z.style.display = "block";
    x.style.display = "none";
  }
}
</script>

	<div class = "frontpage" id = "frontpage">
      <div class="logz"><img src="resource/logo.jpg" alt="logo"> </div>
		<h3>_________________</h3>
		<h3>we PROVIDE your HEALTH CARE needs</h3>
	</div>





    <div id="container" class="container">

        <script>
        //to hide
        var y = document.getElementById("container");
        y.style.display = "none";
        </script>
        
      <div class="header">
        <!-- Insert the title of the page -->

          <!-- Create input fields for the user's first name, last name, email, and password -->
        <h1>Login</h1>
        <form method="post">

                <?php if($is_invalid):?>
                        <em>User id or Password is wrong please try again</em>
                    <?php endif; ?>
                    
            
            <label for="text">User Id:</label>
            <input type="text"  id="email_l" name="email_l" 
            required>
            <label for="password">Password:</label>
            <input type="password" id="pass_l" name="pass_l"
            required>
            <input type="submit" value="Login">
        </form>

        <!--redirerect to register-->
        <div class="register-link">
            <a href="forgot-pass.php">Forgot password?</a>
            <br>
            <p>Don't have an account?</p>
            <a href="register_1.html">Register now</a>
        </div>
    </div>
    </div>

</body>
</html>