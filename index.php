<?php session_start();?>
<!DOCTYPE html>
<html style="overflow-x:hidden;">
  <head>
    <meta charset="UTF-8">
    <title>NZSE booking system</title>
		<link rel="stylesheet" href="css/main_style.css"/>
        <link rel="stylesheet" href="css/animation.css">
	<script src="js/jquery-1.9.1.js"></script>
<script src="js/alertify.min.js"></script>
<link rel="stylesheet" href="css/css_alertboxes/alertify.core.css" />
<link rel="stylesheet" href="css/css_alertboxes/alertify.default.css" />
  </head>
  <body>
	<div id="header_elements">
	<div id="nzseLogo"><img src="pic/logo.png" id="logo"></div>
	</div>
    <div class="wrapper">
	<div class="container"><br />
		<div id='error_index'>
		<?php
				if(isset($_SESSION['error']))
				{	
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}
		?>
		</div><!--error-->
	
		<form id="index" method="post" action="./php_script/index_login_script.php">
			<input type="text" placeholder="Username" id ='uname' name='uname'>
			<input type="password" placeholder="Password" id ='passwd' name='passwd'>
			<button type="submit" id="login-button">Login</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
	</div>
    <script>
	$("#index").on('submit', function () 
		{	
			var flag;
			var d = 5000;
			var uname = document.forms["index"]["uname"].value;
			if (uname == null || uname == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("fill in userid");
				flag=false;
			}
			var passwd = document.forms["index"]["passwd"].value;
			if (passwd == null || passwd == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("fill in password");
				flag=false;
			}
			
			return flag;
		});
		</script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	
 <div id = "index_footer"> 
 <?php include './php_includes/footer.php'; ?>
 </div>
 
  </body>
</html>
