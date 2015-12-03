<?php

	include_once('../database/connection.php'); // connects to the database
	session_start();                         // starts the session
	
	if(isset($_POST['participate'])){
		global $db;
		$id = trim($_POST['id']);
		
		$stmt = $db->prepare("INSERT INTO participante (id, participante) VALUES (:id, :participante)");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':participante', $_SESSION['username']);
		$stmt->execute();
		
		
		header('Location: event.php?id=' . $id);
	}

?>
