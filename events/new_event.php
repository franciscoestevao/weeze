<?php
	session_start();                         // starts the session
	include_once('../database/connection.php'); // connects to the database
	
	
	function NewEvent(){
		global $db;
        $nome=trim($_POST['nome_do_evento']);
		$data=trim($_POST['data_do_evento']);
		$local=trim($_POST['local_do_evento']);
		$descricao=trim($_POST['descricao_do_evento']);
		$tipo=trim($_POST['tipo_do_evento']);
		$imagem=$_POST['imagem_do_evento'];
        $criador = $_SESSION['username'];
        
        $stmt = $db->prepare("INSERT INTO evento (nome, data, local, descricao, tipo, imagem,criador) VALUES (:nome,:data,:local,:descricao,:tipo,:imagem,:criador)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':imagem', $imagem);      
        $stmt->bindParam(':criador', $criador);

        if($stmt->execute()){  
            $_SESSION['loggedin'] = true;
            $_SESSION['img'] = $img;
            header('Location: my_events.php');
            exit();
        }
        
}


	if(isset($_POST['submit'])){
		NewEvent();
	}

?>
