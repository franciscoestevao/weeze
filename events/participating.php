<?php
	session_start();                         // starts the session
	include_once('../database/connection.php'); // connects to the database
	
	
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
	}
	else {
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
                <a href="my_events.php"><p>My Events</p><a/>
            </div>
        </div>
                <?php 
					global $db;
					$currUsername = $_SESSION['username'];
                    
                    //PAGINATION
                    // Find out how many items are in the table
                    $stmt = $db->prepare('SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = :curruser');
                    // Bind the query params
                    $stmt->bindParam(':curruser', $currUsername);
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


                    // Display the paging information
                //echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';

                    // Prepare the paged query
                    $stmt = $db->prepare('SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN participante WHERE participante = :curruser ORDER BY id DESC LIMIT :limit OFFSET :offset');
                    // Bind the query params
                    $stmt->bindParam(':curruser', $currUsername);
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();

                    $result = $stmt->fetchAll();
                ?>
                
        <div id="section">
			<h1>Participating</h1>
            <h5>Total of participations: <?php echo count($result); ?></h5>
			
			   <div class="allevents">
            
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
        
            <div class="pagination">
            <p><?php echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, $nextlink, ' </p></div>';?></p>    
            </div>
			
        </div>

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
