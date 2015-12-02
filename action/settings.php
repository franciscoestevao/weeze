<?php
session_start();
include_once('../database/connection.php'); // connects to the database

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
} else {
    header('Location: ../errors/no_login_error.php');
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
                <a href="../action/settings.php" class="link"><p><img src="../img/config.svg" height="10px">  Settings</p></a>  
                </div>
            </div>
            <div class="separator">
            </div>
            
            <div class="list">
				<a href="../events/create_event.php"><p>Create Event</p></a>
                <a href="../main/main.php"><p>All Events</p></a>
                <a href="../events/my_events.php"><p>My Events</p></a>
            </div>
            
            <div class="separator"> </div>
        </div>

        <div id="section">
            <h1>Settings</h1>
            <h5>Change Password</h5>
            <form class="new-event-form" action="new_config.php" method="post" enctype="multipart/form-data">
					<label>New password:
						<input type="password" name="pass" class="input" id="pass" autocomplete="off" required="true">
					</label><br>
                    <label>Repeat new password:
						<input type="password" name="cpass" class="input" id="pass" autocomplete="off" required="true">
					</label>
                    <br>
					<input id="button" type="submit" name="submit" class="button" value="Submit">
			</form>        
       
        </div>

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
