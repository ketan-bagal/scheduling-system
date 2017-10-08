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
	<?php $title="Add Course"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Add Course</h1>
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
						<form id="form1" action="./admin_addcourse_script.php" method="post">
							<fieldset>
								<input type="text" name="courseid" placeholder = "Course Code">
								<input type="text" name="coursename" placeholder="Enter Course name">
								<?php
								include '../php_script/connectDB.php';
								$sql="SELECT * FROM programme";
								$result = mysqli_query($conn,$sql);
								echo "
								<select name='programmeid' id='programmeid'>";
								echo "<option value='' hidden selected>Select a programme</option>";
								while($row = mysqli_fetch_array($result)) {
									$currentbid = $row['programmeid'];
									echo "<option data-duration=".$row['duration']." value=".$currentbid; if(isset($schoolid)) {if($schoolid==$currentbid) {echo " selected";}} echo ">" .$row['name']."</option>";
								}
								echo "</select>";
								mysqli_close($conn);
								?>
								<input type="number" name="duryear" min="0" max="10" value="" placeholder="Duration by year">
								<input type="number" name="durweek" min="0" max="51" value="" placeholder="Duration by week">
								<input type="text" name="credits" placeholder="Credits">
								<input type="number" name="level" min="0" max="10" value="" placeholder="Level">
							</fieldset>

							<input type='submit' name='submit' value='Submit'>

						</form>
					</div>
				</div>
			</div>
</div>
<script>
	function hasSpecialChar(str)
	{
		var pattern = new RegExp(/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/);
		return pattern.test(str);
	}
	
	var programmeDuration=0;
	
	$(document).ready(function() {
		$('#programmeid').change(function() {
			programmeDuration = $('#programmeid').find(':selected').attr('data-duration');
		});
	});

	$("#form1").on('submit', function ()
		{
			var flag;
			var d = 5000;

			var courseid = document.forms["form1"]["courseid"].value.trim();
			if (courseid == null || courseid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Course code is required");
				flag=false;
			}
			else if (hasSpecialChar(courseid))
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("course id has special characters");
				flag=false;
			}
			
			var coursename = document.forms["form1"]["coursename"].value.trim();
			if (coursename == null || coursename == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Coursename is required");
				flag=false;
			}
			else if (hasSpecialChar(coursename))
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("course name has special characters");
				flag=false;
			}
			
			var programmeid = document.forms["form1"]["programmeid"].value.trim();
			if (programmeid == null || programmeid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Programme is required");
				flag=false;
			}
			else
			{
				
			var dyear = document.forms["form1"]["duryear"].value.trim();
			var dweek = document.forms["form1"]["durweek"].value.trim();
			
			if(!dyear)
			{
				dyear = 0;
			}
			
			if(!dweek)
			{
				dweek = 0;
			}
			
			dyear = parseInt(dyear);
			dweek = parseInt(dweek);
			
			var courseDuration = dyear * 52 + dweek;
			
			if (dyear == 0 && dweek == 0)
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("course duration is required");
				flag=false;
			}
			else if(courseDuration > programmeDuration)
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("course duration cannot be longer than the programme duration (" + programmeDuration + " weeks)");
				flag=false;
			}
			
			}
			
		
			
			
			
			var credits = document.forms["form1"]["credits"].value.trim();
			if (credits == null || credits == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Credits is required");
				flag=false;
			}
			else if(hasSpecialChar(credits))
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Credits has special characters");
				flag=false;
			}
			else if (credits < 0)
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Credits cannot be negative");
				flag=false;
			}
		
			var level = document.forms["form1"]["level"].value.trim();
			if (level == null || level == 0)
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Level is required");
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
