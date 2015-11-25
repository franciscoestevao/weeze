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
		
		<h1>BASIL AFTER LOGIN</h1>
		<a href="action/logout.php">Logout</a>
		<img src="http://www.gourmetgarden.com/sites/gourmetgarden.sites.go1.com.au/files/atp_gen_gourm_0210_189_basil.jpg"
		 alt="basil" width="300" height="200">
	</head>

	<body>
		<form method="POST" action='action/register.php'>
			Username:
			<input type="text" name="user">
			<br>
			Nome:
			<input type="text" name="nome">
			<br>
			Password:
			<input type="password" name="pass">
			<br>
			Confirm password:
			<input type="password" name="cpass">
			<br>
			<input id="button" type="submit" name="submit" value="Registar">
			<br><br>
		</form>
	</body>

</html>
