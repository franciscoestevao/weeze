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
				<a href="../events/create_event.php"><p>Create Event</p></a>
                <a href="../events/my_events.php"><p>My Events</p></a>
                <a href="../events/invited.php"><p>Invites</p></a>
                <a href="../events/participating.php"><p>Participating</p></a>
            </div>
            
            <div class="separator"> </div>
        
            <div class="filter">
                <h3>Search & Filter</h3>
                <form action="../events/filter.php" method="post">
				    <input type="text" name="search" class="input" id="search" autocomplete="on"><br>
                    <input type="checkbox" name="party" id="party"/>
                    <label for="party" class="txtchkbox">Party</label><br>
                    
                    <input type="checkbox" name="concert" id="concert"/>
                    <label for="concert" class="txtchkbox">Concert</label><br>
                    
                    <input type="checkbox" name="sports" id="sports"/>
                    <label for="sports" class="txtchkbox">Sports</label><br>
                    
                    <input type="checkbox" name="festival" id="festival"/>
                    <label for="festival" class="txtchkbox">Festival</label><br>
                    
                    <input type="checkbox" name="other" id="other"/>
                    <label for="other" class="txtchkbox">Other</label><br>
                    
                    <br><input type="submit" id="button" name="formSubmit" value="Search" />
                </form>
            </div>
        </div>
        
        <?php 
			global $db;        
            //PAGINATION
            // Find out how many items are in the table
            $stmt = $db->prepare('SELECT * FROM evento WHERE privado = "false" UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = :curruser UNION SELECT * FROM evento WHERE criador = :curruser1');
            $stmt->bindParam(':curruser', $_SESSION['username']);
            $stmt->bindParam(':curruser1', $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total = count($result);
            $limit =9;
            $pages = ceil($total/$limit);


            // What page are we currently on?
            $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' => array('default'   => 1,'min_range' => 1,),)));

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;

            // Some information to display to the user
            $start = $offset + 1;
            $end = min(($offset + $limit), $total);

            // The "back" link
            $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

            // The "forward" link
            $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';


            // Prepare the paged query
            $stmt = $db->prepare('SELECT * FROM evento WHERE privado = "false" UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = :curruser UNION SELECT * FROM evento WHERE criador = :curruser1 ORDER BY id DESC LIMIT :limit OFFSET :offset');
            // Bind the query params
            $stmt->bindParam(':curruser', $_SESSION['username']);
            $stmt->bindParam(':curruser1', $_SESSION['username']);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
        
        ?>

        <div id="section">
        <h1>Latest Events</h1>
        <h5>
			Here are the latest events:
        </h5>
        <div class="allevents">
            
           <ul>
			<?php
				if(count($result)){
				foreach ($result as $row){	
                    if (strlen($row['nome'])>27){
                        $row['nome'] = substr($row['nome'], 0, 22);
                        $row['nome'] = $row['nome'].'...';
                    }
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
        
            <div class="pagination">
            <p><?php echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, $nextlink, ' </p></div>';?></p>    
            </div>
        </div>

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
