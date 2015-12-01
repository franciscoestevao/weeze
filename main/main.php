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
                <a href="../action/logout.php" class="link"><p><img src="../img/config.svg" height="10px">  Settings</p></a>  
                </div>
            </div>
            <div class="separator">
            </div>
            
            <div class="list">
				<a href="../events/create_event.php"><p>Create Event</p></a>
                <a href="../events/my_events.php"><p>My Events</p></a>
            </div>
            
            
            <div class="separator"> </div>
        
            <div class="filter">
                <h3>Search & Filter</h3>
                <form action="../events/filter.php" method="post">
				    <input type="text" name="search" class="input" id="search" autocomplete="off" required="false">
                    <br><input type="checkbox" name="Party" value="Party"/><br><br>
                    <input type="submit" id="button" name="formSubmit" value="Search" />
                </form>
            </div>
        </div>
        
        <?php 
			global $db;
			
			$stmt = $db->prepare("SELECT * FROM evento order by id DESC");
			$stmt->execute();
			$result = $stmt->fetchAll();
        ?>

        <div id="section">
        <h1>Latest Events</h1>
        <h5>
			Here are the latest events:
        </h5>
        
        <ul>
			<?php
				if(count($result)){
				foreach ($result as $row){
			?>
             <div class="cont">
                 <div class="contImg">
              <?php $thumb=$row['imagem']; ?>
						<img src="<?php echo $thumb; ?>">
                </div>
			<div class="event">
               
				<li>
					<a href="../events/event.php?id=<?php echo $row['id']; ?>">
                        <h4><?php echo $row['tipo']; ?></h4><br>
						<h1><?php echo $row['nome']; ?></h1><br>
						<h2><?php echo $row['data']; ?> | Hosted by: <?php echo $row['criador']; ?></h2>   
					</a>
                    
				</li>
			</div>
            <br> 
            </div>
           
			<?php }} ?>
		</ul>
       
        </div>

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
