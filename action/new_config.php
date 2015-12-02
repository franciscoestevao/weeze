<?php
include_once('../database/connection.php'); // connects to the database
session_start();                         // starts the session        

$password=trim($_POST['pass']);
$cpassword=trim($_POST['pass']);

if($password !== $cpassword) {
            //echo "<script> window.location.assign('../errors/password_error.php'); </script>";
			header('Location: ../errors/password_error.php');
		}
else{
    
    $password = md5($password);
}

?>