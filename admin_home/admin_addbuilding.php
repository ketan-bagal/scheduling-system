<?php session_start();?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}

?>
<!--bring values into form-->
<?php
	if(isset($_GET['copy']) || isset($_GET['edit'])|| isset($_SESSION['errorid']))
	{
		if(isset($_GET['copy']))
		{
		$buildingid=$_GET['copy'];
		}
		elseif(isset($_GET['edit']))
		{
		$buildingid=$_GET['edit'];
		}

		else
		{
			$buildingid=$_SESSION['errorid'];
			unset($_SESSION['errorid']);
		}
	include '../php_script/connectDB.php';
	$result = "SELECT b.* FROM building b WHERE b.buildingid='".$buildingid."'";
		if($runquery=mysqli_query($conn,$result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$_SESSION['campusid']=$row['campusid'];
				$_SESSION['buildingid']=$row['buildingid'];
				$_SESSION['buildingname']=$row['buildingname'];

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
	<?php $title="Add building"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">


			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Add Building</h1>

<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{
					print $_SESSION['error'];
					if(isset($_SESSION['lead']))
					{
						print $_SESSION['lead'];
					}
					unset($_SESSION['error']);
					unset($_SESSION['lead']);
				}

		?>
</div><!--error--><br />
<div id="container">


<div class="form">
<form id="form1" action="./admin_addbuilding_script.php" method="post">
 <fieldset>


<input type="text" name="buildingname" placeholder="Building name" value="<?php if(isset($_SESSION['buildingname'])) echo $_SESSION['buildingname'];?>">

<?php
include '../php_script/connectDB.php';

$sql="SELECT * FROM campus";
$result = mysqli_query($conn,$sql);

echo "<select name='campusid'>";
echo "<option value='' hidden selected>Select a campus</option>";
while($row = mysqli_fetch_array($result)) {
	$campusid = $row['campusid'];
	echo "<option value=".$campusid; if(isset($_SESSION['campusid'])) {if($_SESSION['campusid']==$campusid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>
</fieldset>

<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='Submit' >";$_SESSION['updatingid']=$_SESSION['buildingid'];}
else {echo "<input type='submit' name='new' value='Submit' >";}?>

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

			var buildingname = document.forms["form1"]["buildingname"].value;
			if (buildingname == null || buildingname == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("building name is required");
				flag=false;
			}else{
				var regex = /^[^\s\t].{2,39}$/;
				if(!regex.test(buildingname))
				 {
					 d += 500;
					alertify.set({ delay: d });
					alertify.log("Please try 3-40 characters for the building name");
					flag=false;
				 }
			}
			var campusid = document.forms["form1"]["campusid"].value;
			if (campusid == null || campusid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("campus is required");
				flag=false;
			}

			return flag;
		});
		</script>
<?php
	unset($_SESSION['buildingid'],$_SESSION['campusid'],$_SESSION['buildingname']);
?>
<br><br>

<?php include '../php_includes/footer.php';?>

</body>
</html>
