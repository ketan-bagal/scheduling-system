<?php session_start();?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Add School"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Add School</h1>
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
						<form id="form1" action="./admin_addschools_script.php" method="post">
							<fieldset>
								<input type="text" name="schoolname" placeholder="School name" value="">
							</fieldset>
							<input type='submit' name='submit' value='submit'>
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

			var schoolname = document.forms["form1"]["schoolname"].value;
			if (schoolname == null || schoolname == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("School name is required");
				flag=false;
			}
			return flag;
		});
		</script>


<br><br>
<div id = "index_footer">
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
