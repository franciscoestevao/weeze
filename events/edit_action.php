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
	
	
?>
