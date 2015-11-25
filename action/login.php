<?php
include_once('../database/connection.php'); // connects to the database
session_start();                         // starts the session

function Login()
{
    
       global $db;
        $username=trim($_POST['userLog']);
		$password=trim($_POST['passLog']);
		
        $stmt = $db->prepare("SELECT * FROM utilizador WHERE username = '".$username."' AND password = '".$password."'");
		$stmt->execute();
		$result = $stmt->fetchAll();
        if(count($result)){
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            foreach ($result as $row){
                $img = $row['img'];
            }
            $_SESSION['img']=$img;
            echo "<script> window.location.assign('../main.php'); </script>";
            //header('Location: main.php');
            
        }  else{
            echo "<script> window.location.assign('../index.html'); </script>";
            //header('Location: index.html');
        }        
}


if(isset($_POST['login'])){
	Login();
}
?>
