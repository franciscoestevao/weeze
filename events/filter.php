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
                    $search=trim($_POST['search']);
                    $party=trim($_POST['party']);
                    $concert=trim($_POST['concert']);
                    $sports=trim($_POST['sports']);
                    $festival=trim($_POST['festival']);
                    $other=trim($_POST['other']);
                    $curruser = $_SESSION['username'];
                    
                    
                
                    //$sqlSt = "(SELECT * FROM evento WHERE privado = 'false' UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = '".$curruser."' UNION SELECT * FROM evento WHERE criador = '".$curruser."') WHERE ";
                    
                    
                    
                    if($search != ""){
                        $sqlSt .= "nome LIKE '%".$search."%' AND (";
                    }else $sqlSt .= "(";
                
                    if($party == "on"){
                        $sqlSt .= " tipo = 'party'";
                        $alt = true;
                    }
                    
                    if($concert == "on"){
                        if($alt){
                        $sqlSt .= " OR tipo = 'concert'";   
                        }
                        else{
                        $sqlSt .= " tipo = 'concert'"; 
                        $alt = true;
                        }
                    }
                
                    if($sports == "on"){
                        if($alt){
                        $sqlSt .= " OR tipo = 'sports'";   
                        }
                        else{
                        $sqlSt .= " tipo = 'sports'"; 
                        $alt = true;
                        }
                    }
                        
                    if($festival == "on"){
                        if($alt){
                        $sqlSt .= " OR tipo = 'festival'";   
                        }
                        else{
                        $sqlSt .= " tipo = 'festival'";
                        $alt = true;
                        }
                    }
                
                
                    if($other == "on"){
                        if($alt){
                        $sqlSt .= " OR tipo = 'other'";   
                        }
                        else{
                        $sqlSt .= " tipo = 'other'";
                        $alt = true;
                        }
                    }
                    
                    //CASO HAJA PESQUISA NA TEXTBOX E TICK
                    if($alt && ($search != "")){
                        $sqlSt .= ")";
                        $completeSql = "SELECT * FROM evento WHERE privado = 'false' AND ".$sqlSt." UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = '".$curruser."' AND ".$sqlSt." UNION SELECT * from evento WHERE criador = '".$curruser."' AND ".$sqlSt;
                        
                    }    
                
                    
                    //CASO SO HAJA PESQUISA
                    else if(!$alt && ($search != "")){
                        $sqlSt = "nome LIKE '%".$search."%' ";
                        $completeSql = "SELECT * FROM evento WHERE privado = 'false' AND ".$sqlSt." UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = '".$curruser."' AND ".$sqlSt." UNION SELECT * from evento WHERE criador = '".$curruser."' AND ".$sqlSt; 
                       // die("$completeSql");
                
                    }
                    
                    //CASO SO HAJA TICKS
                    
                    else if($alt && !($search != "")){
                        $sqlSt .= ")";
                        $completeSql = "SELECT * FROM evento WHERE privado = 'false' AND ".$sqlSt." UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = '".$curruser."' AND ".$sqlSt." UNION SELECT * from evento WHERE criador = '".$curruser."' AND ".$sqlSt; 
                       // die("$completeSql");
                    }
                    
                    //CASO NAO HAJA TICKS NEM PESQUISA
                    
                    else if(!$alt && !($search != "")){
                        $sqlSt .= ")";
                        $completeSql = "SELECT * FROM evento WHERE privado = 'false' UNION SELECT id, nome, data, local, descricao, tipo, imagem, criador, privado FROM evento NATURAL JOIN convidado WHERE convidado = '".$curruser."' UNION SELECT * from evento WHERE criador = '".$curruser."'"; 
                    }
                
                    $completeSql .= " ORDER BY id DESC";
                
                    //die("$completeSql");
                    
					$stmt = $db->prepare($completeSql);
					//$stmt->bindParam(':curruser', $currUsername);
					$stmt->execute();
					$result = $stmt->fetchAll();
                ?>
                
        <div id="section">
			<h1>Search & Filter</h1>
            <h5>Total of events: <?php echo count($result); ?></h5>
			
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

        <div id="footer">
        <p>weeze - event manager | developed by Francisco Estêvão & Tomás Tavares | © LTW FEUP 2015/2016</p> 
        </div>

	</body>

</html>
