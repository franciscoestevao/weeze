<?php
	session_start();                         // starts the session
	include_once('../database/connection.php'); // connects to the database


	if(isset($_POST['submit'])){
		
		$id_evento=trim($_POST['id_evento']);
		$texto=trim($_POST['comentario']);
		$username=trim($_POST['username']);
		
		global $db;
        
        $stmt = $db->prepare("INSERT INTO comentario (id_evento, texto, username) VALUES (:id_evento,:texto,:username)");
        $stmt->bindParam(':id_evento', $id_evento);
        $stmt->bindParam(':texto', $texto);
        $stmt->bindParam(':username', $username);	

        if($stmt->execute()){  
            $_SESSION['loggedin'] = true;
            $_SESSION['img'] = $img;
            //die('Location: event.php?id='.$id_evento);
            header("Location: event.php?id=".$id_evento);
            exit();
        }

	}

?>
