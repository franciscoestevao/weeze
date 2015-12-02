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
	  header('Location: my_events.php');
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
            <a href="http://www.google.com"><p>Know more about this project</p></a><div id="knowMore">
            
        </div>
        </div>
        

        <div id="nav">
            <div class="user">
                <div class="photo">
					<h1><?php echo $_SESSION['img'];?></h1>
                </div>
                <div class="info">
					<h1>Welcome back, <?php echo $_SESSION['username'];?>!</h1>    
					<a href="../action/logout.php" class="link"><p><img src="../img/logout.svg" height="10px">  Logout</p></a>
					<a href="../action/logout.php" class="link"><p><img src="../img/config.svg" height="10px">  Settings</p></a>  
                </div>
            </div>
            <div class="separator">
            </div>
            
            <div class="list">
                <a href="create_event.php"><p>Create Event</p><a/>
                <a href="../main/main.php"><p>All Events</p><a/>
            </div>
        </div>
       
       <?php 
			global $db;
			$id=$_GET['id'];
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
            }
		?>
       
                
        <div id="section">
			<h1><?php echo $nome; echo " ($tipo)"; ?></h1>
			<h3><?php echo $data; ?></h3>
            <img src="<?php echo $imagem; ?>" onclick="window.open(this.src)" id="imagem-evento">
			
			<h4><u>Description</u>:<br> <?php echo $desc; ?></h4>
			
			<?php
				if($_SESSION['username'] === $row['criador']){
			?>
			
			<form action='edit.php?id=<?php echo $id; ?>' method="post">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="submit" name="edit" value="Edit" class="button">
			</form>
			
			<form action='delete.php' method="post">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input type="submit" name="delete" value="Delete" class="button" onClick="return confirm('Tem a certeza que quer apagar este evento? Olhe que depois não há volta a dar...')">
			</form>
			
			<form action="edit_action.php" method="post">
				<label>Invite:
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="text" name="convidado" class="input" id="convidado" autocomplete="off">
					<input type="submit" name="invite" value="Invite" class="button">
				</label>
			</form>
			
			<?php } ?>
			
			
			
        </div>
        
				

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>

