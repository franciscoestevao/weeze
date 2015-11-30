<?php
	
	include_once('../database/connection.php'); // connects to the database
	session_start();                         // starts the session
	
	if(isset($_POST['delete'])){
		global $db;
		$id = trim($_POST['id']);
		$stmt = $db->prepare("DELETE FROM evento WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		header('Location: my_events.php');
	}
?>
