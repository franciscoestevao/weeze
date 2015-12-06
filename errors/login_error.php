<!DOCTYPE html>

<html>

	<head>
		<title>weeze</title>
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css"  href="../css/style.css">
	</head>

	<body>
        
        
        <nav id="topmenu" class="navbar">
            <img src="../img/logoTop.png" height="40px">   
        </nav>
        
        <div id="messageBox">
            <h3>Be part of the largest network of events in the world</h3> 
            <div class="separator"></div>
            <h2>Start Weezing</h2>
        </div>
         <div class="form-wrap">
                <div class="tabs">
                    <h3 class="signup-tab"><a href="#signup-tab-content">Sign Up</a></h3>
                    <h3 class="login-tab"><a class="active" href="#login-tab-content">Login</a></h3>
                </div><!--.tabs-->

                <div class="tabs-content">
                    <div id="signup-tab-content">
                        <form class="signup-form" action="../action/register.php" method="post">				
                            <input type="text" class="input" name="user" id="user_name" autocomplete="off" placeholder="Username" required="true">
                            <input type="text" class="input" name="nome" id="name" autocomplete="off" placeholder="Nome" required="true">
                            <input type="password" class="input" name="pass" id="user_pass" autocomplete="off" placeholder="Password" required="true">
                            <input type="password" class="input" name="cpass" id="user_cpass" autocomplete="off" placeholder="Confirme a Password" required="true">
                            <input type="submit" class="button" name="submit" value="Sign Up">
                        </form><!--.login-form-->
                    </div><!--.signup-tab-content-->

                    <div id="login-tab-content" class="active">
                        <form class="login-form" action="../action/login.php" method="POST">
							<b><font color="red">Username ou password inválidos</font></b>
							<br><br>
                            <input type="text" name="userLog" class="input" id="user_login" autocomplete="off" placeholder="Email or Username" required="true">
                            <input type="password" name="passLog" class="input" id="user_pass" autocomplete="off" placeholder="Password" required="true">
                            <input type="submit" id="button" class="button" name="login" value="Login">
                        </form><!--.login-form-->
                    </div><!--.login-tab-content-->
                </div><!--.tabs-content-->
            </div><!--.form-wrap-->
            <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
            <script src="../js/index.js"></script>
	</body>

</html>



