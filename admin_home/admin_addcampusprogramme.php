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
	<?php $title="Define CampusProgramme"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Define CampusProgramme</h1>
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
						<form id="form1" action="./admin_addcampusprogramme_script.php" method="post">
							<fieldset>

								<?php
								include '../php_script/connectDB.php';
								$sql="SELECT * FROM campus";
								$result = mysqli_query($conn,$sql);
								echo "
								<select name='campusid' id='campusid'>";
								echo "<option value='' hidden selected>Select a campus</option>";
								while($row = mysqli_fetch_array($result)) {
									$currentbid = $row['campusid'];
									echo "<option value=".$currentbid; if(isset($schoolid)) {if($schoolid==$currentbid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
								}
								echo "</select>";
								mysqli_close($conn);
								?>
								<?php
								include '../php_script/connectDB.php';
								$sql="SELECT * FROM programme";
								$result = mysqli_query($conn,$sql);
								echo "
								<select name='programmeid' id='programmeid'>";
								echo "<option value='' hidden selected>Select a programme</option>";
								while($row = mysqli_fetch_array($result)) {
									$currentbid = $row['programmeid'];
									echo "<option value=".$currentbid; if(isset($schoolid)) {if($schoolid==$currentbid) {echo " selected";}} echo ">" .$row['name']."</option>";
								}
								echo "</select>";
								mysqli_close($conn);
								?>
							</fieldset>

							<input type='submit' name='submit' value='Submit'>

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

			var campusname = document.forms["form1"]["campusid"].value;
			if (campusname == null || campusname == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Campus  is required");
				flag=false;
			}
			var address = document.forms["form1"]["programmeid"].value;
			if (address == null || address == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Programme is required");
				flag=false;
			}
			return flag;
		});
		</script>

<?php
	unset($_SESSION['campusname'],$_SESSION['campusid'],$_SESSION['address']);
?>
<br><br>
<div id = "index_footer">
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
