<?php session_start();?>
<!--bring values into form-->
<?php
	if(isset($_GET['copy']) || isset($_GET['edit']) || isset($_SESSION['errorid']))
	{
		if(isset($_GET['copy']))
		{
		$userid=$_GET['copy'];
		}
		elseif(isset($_GET['edit']))
		{
		$userid=$_GET['edit'];
		}
		else
		{
			$userid=$_SESSION['errorid'];
			unset($_SESSION['errorid']);
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0	 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Edit profile"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit profile</h1>

<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}

		?>
</div><!--error--><br />
<div id="container">
<div class="form">
<br />
	<form id="form1" action="./editemail.php" method="post">
	<input type='submit' name='email' value='Edit email'>
	</form>

	<form id="form1" action="./editpassword.php" method="post">
	<input type='submit' name='password' value='Edit password'>
	</form>

</div>
</div>
		</div>
		</div>
<script>
	$("#form1").on('submit', function ()
		{
			var flag;
			var d = 5000;
			var email = document.forms["form1"]["newEmail"].value;
			if (email == null || email == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Email is required");
				flag=false;
			}else{
				 var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				 if(!regex.test(email))
				 {
					 d += 500;
					alertify.set({ delay: d });
					alertify.log("Please enter correct email.");
					flag=false;
				 }
			}
			
			return flag;
		});
		</script>

<?php
	unset($_SESSION['uid'],$_SESSION['email']);
?>
<br><br>

<?php include '../php_includes/footer.php';?>

</body>
</html>
