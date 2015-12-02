<?php



include_once('../database/connection.php'); // connects to the database
session_start();                         // starts the session

if(isset($_POST['submit'])){
	global $db;
        $username=trim($_POST['user']);
		$nome=trim($_POST['nome']);
		$password=trim($_POST['pass']);
		$cpassword=trim($_POST['cpass']);
	   	
		if($password !== $cpassword) {
            //echo "<script> window.location.assign('../errors/password_error.php'); </script>";
			header('Location: ../errors/password_error.php');
		}
		
		else{
			$stmt = $db->prepare('SELECT username FROM utilizador');
			$stmt->execute();
			$result = $stmt->fetchAll();
			foreach ($result as $row) {
				if($row['username'] === $username){
					header('Location: ../errors/username_error.php');
				}
			}
			
			
			
			$img = rand(0,10);
			$password = md5($password);
			$stmt = $db->prepare("INSERT INTO utilizador (username,nome,password,img) VALUES (:username,:nome,:password,:img)");
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':nome', $nome);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':img', $img);
			if($stmt->execute()){  
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['img'] = $img;
				header('Location: ../main/main.php');
			}
		}
}

?>

