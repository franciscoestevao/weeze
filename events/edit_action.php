<html>
	<head>
		<title>weeze</title>
		<script src="../sweetalert-master/dist/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../sweetalert-master/dist/sweetalert.css">
	</head>
</html>


<?php

	
	include_once('../database/connection.php'); // connects to the database
	session_start();                         // starts the session
	
	if(isset($_POST['submit'])){
		global $db;
		$id = trim($_POST['id']);
		$nome=trim($_POST['nome_do_evento']);
		$data=trim($_POST['data_do_evento']);
		$local=trim($_POST['local_do_evento']);
		$descricao=trim($_POST['descricao_do_evento']);
		$tipo=trim($_POST['tipo_do_evento']);
        $criador = $_SESSION['username'];
        $privacidade = trim($_POST['privacidade']);
        
        $target_dir = "../uploads/" . $_SESSION['username'] . $nome;
		$target_file = $target_dir . basename($_FILES["imagem_do_evento"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["imagem_do_evento"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["imagem_do_evento"]["size"] > 1000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (!move_uploaded_file($_FILES["imagem_do_evento"]["tmp_name"], $target_file)) {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	
        
        $stmt = $db->prepare("UPDATE evento SET nome=:nome, data=:data, local=:local, descricao=:descricao, tipo=:tipo, imagem=:imagem, criador=:criador, privado=:privado WHERE id=:id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':imagem', $target_file);      
        $stmt->bindParam(':criador', $criador);
        $stmt->bindParam(':privado', $privacidade);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
        
        header('Location: event.php?id=' . $id);
		
	}
	
	function isInvited($user, $id){
		
		global $db;
		$stmt = $db->prepare("SELECT * FROM convidado WHERE id=:id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		if(count($result)){
			foreach($result as $row){
				if($user === $row['convidado']){
					return 1;
				}
				else {
					return 0;
				}
			}
		}
		else{
			return 0;
		}
	}
	
	
	function userExists($user){
		
		global $db;
		$stmt = $db->prepare("SELECT * FROM utilizador");
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach ($result as $row){
			if($user == $row['username']){
                
                return 1;
                
			}
		}
        return 0;

	}
	
	if(isset($_POST['invite'])){
		global $db;
		$id = trim($_POST['id']);
		$convidado = trim($_POST['convidado']);
		
		
		if (userExists($convidado) === 1 and isInvited($convidado, $id) === 0){
			
            $stmt = $db->prepare("INSERT INTO convidado (id, convidado) VALUES (:id,:convidado)");
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':convidado', $convidado);
			$stmt->execute();
            $cheese ='Location: event.php?id=' . $id;
            die("$cheese");
    		header('Location: event.php?id=' . $id);
		}
		
		else{
			echo "<script>
			swal({title: 'Error!',   text: 'Username does not exist or is already invited!',   type: 'error',   confirmButtonText: 'OK' }, function(){window.location.assign('event.php?id=$id'); });
			</script>";
			
			
			
			
            //echo '<script> alert("Utilizador não existe ou já está convidado");</script>';
            //echo "<script> window.location.assign('event.php?id=$id'); </script>";
		}
        
	}
	
	
?>
