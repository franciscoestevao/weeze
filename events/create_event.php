<?php
	
	include_once('../database/connection.php'); // connects to the database
	session_start();                         // starts the session
	
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
	}
	else {
		header('Location: ../errors/no_login_error.php');
	}
?>

<html>
	<head>
		<title>weeze</title>
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
                <a href="my_events.php"><p>My Events</p></a>
                <a href="../main/main.php"><p>All Events</p></a>
                <a href="invited.php"><p>Invites</p></a>
            </div>
        </div>

        <div id="section">
			<h1>New Event</h1>
			<form class="new-event-form" action="new_event.php" method="post" enctype="multipart/form-data">
					<label>Title
						<input type="text" name="nome_do_evento" class="input" id="nome" autocomplete="off" required="true">
					</label>
					<br>
					<label>Date
						<input type="date" name="data_do_evento" class="input" id="data" autocomplete="off" required="true">
					</label>
					<br>
					<label>Location
						<input type="text" name="local_do_evento" class="input" id="local" autocomplete="off">
					</label>
					<br>
					<label>Description<br>
						<textarea type="textarea" name="descricao_do_evento" class="input" id="descricao" autocomplete="off" required="true" placeholder="Insira um pequeno texto que descreva o evento" rows="5" cols="40"></textarea>
					</label>
					<br>
					<label>Type
						<!--<input type="text" name="tipo_do_evento" class="input" id="tipo" autocomplete="off" required="true">-->
                        <select name="tipo_do_evento" class="input" id="tipo" required="true">
                          <option value="party">Party</option>
                          <option value="concert">Concert</option>
                          <option value="sports">Sports</option>
                          <option value="festival">Festival</option>
                            <option value="other">Other</option>
                        </select>
					</label>
					<br><br>
					<input type="checkbox" name="privacidade" class="input" id="privado" value="true">Private
					<br><br>
					<label>Image
						<input type="file" name="imagem_do_evento" class="input" id="imagem" autocomplete="off" required="true" accept="image/*">
                    
					</label>
					<br><br>	
					<input id="button" type="submit" name="submit" class="button" value="Submit">
			</form>
			
        </div>

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
