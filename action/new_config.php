<?php
include_once('../database/connection.php'); // connects to the database
session_start();                         // starts the session    



if(isset($_POST['submit'])){
    global $db;
    $password=trim($_POST['pass']);
    $cpassword=trim($_POST['cpass']);

    if($password != $cpassword) {
                //echo "<script> window.location.assign('../errors/password_error.php'); </script>";
                header('Location: ../errors/password_error.php');
            }
    else{
        $username= $_SESSION['username'];
        $password = md5($password);
        $stmt = $db->prepare("UPDATE utilizador SET password=:password WHERE username=:username");
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':username', $username);
        if($stmt->execute()){
				header('Location: ../main/main.php');
			}

    } 
    
}


?>