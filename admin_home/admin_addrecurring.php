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
		$holidayid=$_GET['copy'];
		}
		elseif(isset($_GET['edit']))
		{
		$holidayid=$_GET['edit'];
		}
		else
		{
			$holidayid=$_SESSION['errorid'];
			unset($_SESSION['errorid']);
		}
	include '../php_script/connectDB.php';
	$result = "SELECT h.* FROM coursebooking h WHERE h.coursebookingid='".$holidayid."'";
		if($runquery=mysqli_query($conn,$result))
		{
			while($row = $runquery->fetch_assoc())
			{
				
				$tutor=$row['tutorid'];
		
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
	<?php $title="Edit recurring"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">


			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Recurring</h1>	
	
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
<form id="container" action="./admin_addrecurring_script.php">
 <fieldset>

<?php
include '../php_script/connectDB.php';

$sql="SELECT * FROM tutor";
$result = mysqli_query($conn,$sql);

echo "<label for='module'>Tutor: </label>
<select name='tutor'>";
echo "<option>Select a Tutor</option>";
while($row = mysqli_fetch_array($result)) {
	$tutorid = $row['tutorid'];
	echo "<option value=".$tutorid; if(isset($tutor)) {if($tutor==$tutorid) {echo " selected";}} echo ">" .$row['firstname']." ".$row['lastname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>



<?php
if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='Submit'>";$_SESSION['updatingid']=$holidayid;} else {echo "<input type='submit' name='new' value='Submit' >";}
?>
 </fieldset>
</form>
</div>
</div>
		</div>
		</div>
<script>
	$("#container").on('submit', function () 
		{	
			var flag;
			var d = 5000;
			
			var buildingname = document.forms["container"]["tutor"].value;
			if (buildingname == null || buildingname == "Select a Tutor") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("tutor is required");
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