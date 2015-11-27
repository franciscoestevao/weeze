<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
} else {
    die("Please log in first to see this page.");
}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css"  href="css/styleMain.css">
	</head>

	<body>
		<div id="header">
           <img src="img/logoTopWhite.png" height="25px">  
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
                <a href="action/logout.php" class="link"><p><img src="img/logout.svg" height="10px">  Logout</p></a>
                <a href="action/logout.php" class="link"><p><img src="img/config.svg" height="10px">  Settings</p></a>  
                </div>
            </div>
            <div class="separator">
            </div>
            
            <div class="list">
				<a href="events/redirect_create_event.php"><p>Create Event</p><a/>
                <a href="events/redirect_my_events.php"><p>My Events</p></a>
            </div>
        </div>

        <div id="section">
        <h1>Latest Events</h1>
        <p>
			Here are the latest events:
        </p>
       
        </div>

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
