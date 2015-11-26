
<?php

	include_once('../database/connection.php'); // connects to the database
	session_start();                         // starts the session
	
	function NewEvent(){
		global $db;
        $nome=trim($_POST['nome_do_evento']);
		$data=trim($_POST['data_do_evento']);
		$local=trim($_POST['local_do_evento']);
		$descricao=trim($_POST['descricao_do_evento']);
		$tipo=trim($_POST['tipo_do_evento']);
		$imagem=trim($_POST['imagem_do_evento']);
        
        $stmt = $db->prepare("INSERT INTO evento (nome, data, local, descricao, tipo, imagem) VALUES (:nome,:data,:local,:descricao,:tipo,:imagem)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':local', $local);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':imagem', $imagem);
        
        if($stmt->execute()){  
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['img'] = $img;
            header('Location: my_events.php');
        }

}


	if(isset($_POST['submit'])){
		NewEvent();
	}

?>
