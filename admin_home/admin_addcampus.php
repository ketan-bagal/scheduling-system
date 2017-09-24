<?php session_start();?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}

?>
<!--bring values into form-->
<?php
	if(isset($_GET['copy']) || isset($_GET['edit']) || isset($_SESSION['errorid']))
	{
		if(isset($_GET['copy']))
		{
		$campusid=$_GET['copy'];
		}
		elseif(isset($_GET['edit']))
		{
		$campusid=$_GET['edit'];
		}
		else
		{
			$campusid=$_SESSION['errorid'];
			unset($_SESSION['errorid']);
		}
	include '../php_script/connectDB.php';
	$result = "SELECT c.* FROM campus c WHERE c.campusid='".$campusid."'";
		if($runquery=mysqli_query($conn,$result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$_SESSION['campusname']=$row['campusname'];
				$_SESSION['campusid']=$row['campusid'];
				$_SESSION['address']=$row['address'];

			}
		}
		else
		{
			$_SESSION['error']="couldnt bring copied data";
		}
		mysqli_close($conn);
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Add Campus"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Add Campus</h1>	

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
<form id="form1" action="./admin_addcampus_script.php" method="post">
<fieldset>

<input type="text" name="campusname" placeholder="Campus name" value="<?php if(isset($_SESSION['campusname'])) echo $_SESSION['campusname'];?>">

<input type="text" name="address" placeholder="Address" value="<?php if(isset($_SESSION['address'])) echo $_SESSION['address'];?>">
</fieldset>

<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='Submit'>";$_SESSION['updatingid']=$_SESSION['campusid'];}
else {echo "<input type='submit' name='new' value='Submit'>";}?>

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

			var campusname = document.forms["form1"]["campusname"].value;
			if (campusname == null || campusname == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("campus name is required");
				flag=false;
			}else{
				var regex = /^[^\s\t].{2,39}$/;
				if(!regex.test(campusname))
				 {
					 d += 500;
					alertify.set({ delay: d });
					alertify.log("Please try 3-40 characters for the campus name");
					flag=false;
				 }
			}
			var address = document.forms["form1"]["address"].value;
			if (address == null || address == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("address is required");
				flag=false;
			}
			return flag;
		});
		</script>

<?php
	unset($_SESSION['campusname'],$_SESSION['campusid'],$_SESSION['address']);
?>
<br><br>

<?php include '../php_includes/footer.php';?>

</body>
</html>
