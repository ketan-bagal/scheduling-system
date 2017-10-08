<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<title>error</title>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
	<link rel="stylesheet" href="./css/mystyle.css"/>
</head>

<body>
<div id='container'>
	<header>
	<h1>Your session has expired!</h1>
	</header><!--header-->
	<div id="logoutbutton">
		<?php 
			
					print "<form action='./php_script/logout.php'>";
					print "<input type='submit' value='Login'>";
					print "</form>";	
		?>
	</div><!--logoutbutton-->
	<div id='error_index'>
		<?php
				if(isset($_SESSION['error']))
				{	
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}
		?>
		</div><!--error-->
</div><!--container-->

		
</body>
</html>