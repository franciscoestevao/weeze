<?php
  
include_once('../database/connection.php'); // connects to the database
session_start();                         // starts the session

function NewUser()
{
        global $db;
        $username=trim($_POST['user']);
		$nome=trim($_POST['nome']);
		$password=trim($_POST['pass']);
		$cpassword=trim($_POST['cpass']);
		
		$stmt = $db->prepare('SELECT username FROM utilizador');
		$stmt->execute();
        $result = $stmt->fetchAll();
		foreach ($result as $row) {
			if($row['username'] === $username){
				die("Username já existente, tente outro");
			}
		}
		
		if($password !== $cpassword) {
			die("Passwords têm que coincidir!");
		}
        
        $img = rand(0,10);
        
        $stmt = $db->prepare("INSERT INTO utilizador (username,nome,password,img) VALUES (:username,:nome,:password,:img)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':img', $img);
        if($stmt->execute()){  
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['img'] = $img;
            header('Location: ../main.php');
        }
}


if(isset($_POST['submit'])){
	NewUser();
}

?>
