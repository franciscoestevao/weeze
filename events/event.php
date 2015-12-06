<?php
	session_start();                         // starts the session
	include_once('../database/connection.php'); // connects to the database
	
	
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
	}
	else {
		header('Location: ../errors/no_login_error.php');
	}
	
	if (!isset($_GET["id"])) { 
	  header('Location: ../main/main.php');
	}
	
	global $db;
	$id=$_GET['id'];
	
	$stmt = $db->prepare("SELECT * FROM evento WHERE id=:id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach ($result as $row){
		$privacidade = $row['privado'];
		$criador = $row['criador'];
	}
	
	
	$stmt = $db->prepare("SELECT * FROM convidado WHERE id = :id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	$result = $stmt->fetchAll();
	
	$convidado = $result['convidado'];
	
	
	foreach ($result as $row){
		if($_SESSION['username'] === $row['convidado']){
			$invite=1;
			break;
		}
		else{
			$invite=0;
		}
	}
	
	
	if(($privacidade === "true") && (!isset($convidado)) && ($_SESSION['username'] !== $criador) && ($invite === 0)){

		header('Location: ../main/main.php');
	}
	
	
	
	
	
	$stmt = $db->prepare("SELECT * FROM evento WHERE id = :id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach ($result as $row){
		$nome = $row['nome'];
		$desc = $row['descricao'];
		$imagem = $row['imagem'];
		$data = $row['data'];
		$tipo = $row['tipo'];
        $local = $row['local'];
        $privado = $row['privado'];
	}
	
		
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css"  href="../css/styleMain.css">
	</head>

	<body>
		<div id="header">
           <img src="../img/logoTopWhite.png" height="25px">  
            
        </div>
        </div>
        

        <div id="nav">
            <div class="user">
                <div class="info">
					<h1>Welcome back, <?php echo $_SESSION['username'];?>!</h1>    
					<a href="../action/logout.php" class="link"><p><img src="../img/logout.svg" height="10px">  Logout</p></a>
					<a href="../action/settings.php" class="link"><p><img src="../img/config.svg" height="10px">  Settings</p></a>   
                </div>
            </div>
            <div class="separator">
            </div>
            
            <div class="list">
                <a href="create_event.php"><p>Create Event</p><a/>
                <a href="../main/main.php"><p>All Events</p><a/>
                <a href="invited.php"><p>Invites</p></a>
                <a href="participating.php"><p>Participating</p></a>
            </div>
        </div>
                
                
    
        <div id="navRight">
                <?php
				if($_SESSION['username'] === $row['criador']){
			?>
			<h2>Manage your event:</h2>
			<form action='edit.php?id=<?php echo $id; ?>' method="post" id="edit">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="submit" name="edit" value="Edit" class="button">
			</form>
			
			<form action='delete.php' method="post">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="submit" name="delete" value="Delete" class="button" onClick="return confirm('Are you sure?')">
			</form>
			<h2>Invite friends:</h2>
			<form action="edit_action.php" method="post">
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="text" name="convidado" class="input" id="convidado" autocomplete="off">
					<input type="submit" name="invite" value="Invite" class="button">
			</form>
            
			<?php } ?>
            
            <?php
			
				$stmt = $db->prepare("SELECT * FROM participante WHERE id = :id");
				$stmt->bindParam(':id', $_GET['id']);
				$stmt->execute();
				$resultado = $stmt->fetchAll();
				
				$part = $resultado['participante'];
				
				
				if(count($resultado)){
					foreach ($resultado as $linha){
						if($_SESSION['username'] === $linha['participante']){
							$registado=1;
							break;
						}
						else{
							$registado=0;
						}
					}
				}
				else{
					$registado=0;
				}
			
				

				if($registado===0 and ($row['privado'] === "false" or ($row['privado'] === "true" and ($_SESSION['username']===$row['criador'] or $invite===1)))){
			?>
			<h2>Participate in this event:</h2>
			<form action="participate.php" method="post">
				<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
				<input type="submit" name="participate" value="Participate" class="button">
			</form>
			
			<?php } ?>
            
            <?php
            
            $stmt = $db->prepare("SELECT * FROM convidado WHERE id = :id LIMIT 5");
            $stmt->bindParam(':id', $_GET['id']);
			$stmt->execute();
			$resultado = $stmt->fetchAll();
            
            
            if(count($resultado)){?>
            <h2>Invited:</h2>
            <?php
					foreach ($resultado as $linha){?>
						<h3><?php echo $linha['convidado']; ?></h3>
						<?php }} ?>
            
            <?php
            
            $stmt = $db->prepare("SELECT * FROM participante WHERE id = :id LIMIT 5");
            $stmt->bindParam(':id', $_GET['id']);
			$stmt->execute();
			$resultado = $stmt->fetchAll();
            
            
            if(count($resultado)){?>
            <h2>Going:</h2>
            <?php
					foreach ($resultado as $linha){?>
						<h3><?php echo $linha['participante']; ?></h3>
						<?php }} ?>
            
            
            
            
        </div>
                
        <div id="sectionEvent">
			<h1><?php echo $nome; ?></h1><?php if($privado == 'true'){?><img src="../img/private.svg" height="10px" id="private"><?php } ?>
			<h3><?php echo $data." | ".$local." | ".$tipo; ?></h3>
            <img src="<?php echo $imagem; ?>" onclick="window.open(this.src)" id="imagem-evento">
			<br>
			<h4><?php echo $desc; ?></h4>
            <br>
            
            
            
            
            
            <div class="comments">
                <h1>Comments</h1>
                
                <?php 
                
                $stmt = $db->prepare("SELECT * FROM comentario WHERE id_evento = :id_evento");
                $stmt->bindParam(':id_evento', $id);
                $stmt->execute();
                $resultado = $stmt->fetchAll();
                
                if(count($resultado)){
                foreach ($resultado as $linha){?>
                <div class="oneComment">
                <h2><?php echo $linha['username'].' said:'; ?></h2>
                <p> <?php echo "&nbsp&nbsp&nbsp&nbsp".$linha['texto']; ?></p>
                </div>

                <?php }} ?>
                
                
                <div class="separator">
                </div>
                
                <form action="comment.php" method="post">
                    <input type="hidden" name="id_evento" value="<?php echo $id?>">
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    <textarea type="textarea" name="comentario" class="input" id="comentario" autocomplete="off" required="true" placeholder="Insert your comment." rows="5" cols="50"></textarea><br><br>
					<input type="submit" name="submit" value="Submit" class="button">
			     </form>
                
            </div>
			
        </div>
        
				

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>

