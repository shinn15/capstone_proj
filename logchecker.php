<?php

if(!isset($_SESSION["user_id"])){
    
    $alert1="<script>alert('User not log in!'); window.location.href='index.php'</script>";
    echo($alert1);
    exit;
    
}




?>