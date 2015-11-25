<?php

//$con=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or
	//die("Falha ao conectar com mysql: " . mysql_error());

try {
    $db = new PDO('sqlite:../database/db.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die('Falha ao conectar com a base de dados');
}
?>
