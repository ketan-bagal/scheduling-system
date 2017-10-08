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
	<?php $title="Edit password"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit password</h1>

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
<form id="form1" action="./editprofile_script.php" method="post">
<fieldset>

<input type="password" name="currentp" value="" placeholder="Current password" /><br />
<input type="password" name="newp" value="" placeholder="New password" /><br />
<input type="password" name="confirmp" value="" placeholder="Confirm password" /><br />

</fieldset>

<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='Submit'>";$_SESSION['updatingid']=$_SESSION['uid'];}
else {echo "<input type='submit' name='password' value='Submit'>";}
  ?>

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
			var currentPassword = document.forms["form1"]["currentp"].value;
			if (currentPassword == null || currentPassword == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Current password is required");
				flag=false;
			}

			var newPassword = document.forms["form1"]["newp"].value;
			if (newPassword == null || newPassword == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("New password is required");
				flag=false;
			}else{
				var confirmPassword = document.forms["form1"]["confirmp"].value;
				if(confirmPassword != newPassword){
					d += 500;
					alertify.set({ delay: d });
					alertify.log("Confirm password doesn't match to new password");
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
