
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
            $_SESSION['username'] = $username;
            $_SESSION['img'] = $img;
            header('Location: my_events.php');
        }
        
        
        
		/*$last_id=$db->lastInsertRowID();*/
		
		/*
		$stmt = $db->prepare("SELECT last_insert_rowid()");
		$stmt->execute();
		$result = $stmt->fetchAll();
		$last_id=$result;
		
       
		
		
		
		/*
		$schema="evento";
				$stmt = $db->prepare("SELECT currval('$schema.id') as id");
		$stmt->execute();
		  // get next row as an array indexed by column name
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$last_id=$result["id"];
		*/
		
		/*
		$last_id=sqlite_last_insert_rowid($db);
		
        
        $stmt=$db->prepare("INSERT INTO user_creation (username, e_id) VALUES (:username,:e_id)");
        $stmt->bindParam(':username', $criador);
        $stmt->bindParam(':e_id', $last_id);
        
        */
        
        

}


	if(isset($_POST['submit'])){
		NewEvent();
	}

?>
