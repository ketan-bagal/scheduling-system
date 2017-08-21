<?php session_start();?>
<?php 
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 2){
		header('location:../error_page.php');
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="recurring booking"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Recurring Booking</h1>	
			
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
<form id="container" action="./manager_recurring_view.php">
<fieldset>
<label for='startdate'>Start Week:</label>
<input type="date" name="startdate" value="" />
<label for='enddate'>End Week:</label>
<input type="date" name="enddate" value="" />

<label>Cohort:</label>
<input type="text" name="cohort" value="" placeholder="cohort name" /><br />
<?php
include '../php_script/connectDB.php';

$sql="SELECT * FROM tutor";
$result = mysqli_query($conn,$sql);

echo "<label for='module'>Tutor: </label>
<select name='tutor'>";
echo "<option>Select a Tutor</option>";
while($row = mysqli_fetch_array($result)) {
	$tutorid = $row['tutorid'];
	echo "<option value=".$tutorid; if(isset($_SESSION['tutorid'])) {if($_SESSION['tutorid']==$tutorid) {echo " selected";}} echo ">" .$row['firstname']." ".$row['lastname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>
<?php
include '../php_script/connectDB.php';

$sql="SELECT * FROM campus";
$result = mysqli_query($conn,$sql);

echo "<label for='module'>Campus: </label>
<select name='campusid'>";
echo "<option>Select a campus</option>";
while($row = mysqli_fetch_array($result)) {
	$campusid = $row['campusid'];
	echo "<option value=".$campusid; if(isset($_SESSION['campusid'])) {if($_SESSION['campusid']==$campusid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>
</fieldset>
<input type="submit" name="submit" value="View Available" />
</form>
</div>
</div>
<script>
$("#container").on('submit', function () 
		{	
		
			var flag;
			var d = 5000;
			var startdate = document.forms["container"]["startdate"].value;
			if (startdate == null || startdate == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("startweek is required");
				flag=false;
			}
			var temp = new Date(startdate);
			temp = temp.getDay();
			if (temp != 1) 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("startweek muust start from monday");
				flag=false;
			}
			var enddate = document.forms["container"]["enddate"].value;
			if (enddate == null || enddate == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("endweek is required");
				flag=false;
			}
			var temp2 = new Date(enddate);
			temp2 = temp2.getDay();
			if (enddate == 0) 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("endweek cannot be sunday");
				flag=false;
			}
			var course = document.forms["container"]["cohort"].value;
			if (course == null || course == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("cohort is required");
				flag=false;
			}
			var tutor = document.forms["container"]["tutor"].value;
			if (tutor == null || tutor == "Select a Tutor") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("tutor is required");
				flag=false;
			}
			var campusid = document.forms["container"]["campusid"].value;
			if (campusid == null || campusid == "Select a campus") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("campus is required");
				flag=false;
			}

			return flag;
		});
</script>
</div>

<?php include '../php_includes/footer.php';?>

</body>
</html>
