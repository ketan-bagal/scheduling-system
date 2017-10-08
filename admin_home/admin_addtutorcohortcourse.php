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
	include '../php_script/connectDB.php';
	$result = "SELECT u.* FROM user u WHERE u.userid='".$userid."'";
		if($runquery=mysqli_query($conn,$result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$_SESSION['uid']=$row['userid'];
				$_SESSION['email']=$row['email'];

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
	<?php $title="Add user"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Link tutor with course</h1>

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
<form id="form1" action="./admin_addtutorcohortcourse_script.php" method="post">
<fieldset>

<?php
include '../php_script/connectDB.php';
$sql1="SELECT tutorid, CONCAT (firstname, ' ', lastname) AS name FROM tutor";
$result1 = mysqli_query($conn,$sql1);
echo "
<select id='tutorid' name='tutorid'>";

echo "<option value='' hidden>Select a tutor</option>";

while($row1 = mysqli_fetch_array($result1)) {
	$currentid = $row1['tutorid'];

	echo "<option value='$currentid'"; if(isset($campusid)) {if($campusid==$currentid) {echo " selected";}} echo ">" .$row1['name']."</option>";
}
echo "</select>";

?>

<?php

$sql2="SELECT cohortid FROM cohort";
$result2 = mysqli_query($conn,$sql2);
echo "
<select id='cohortid' name='cohortid' onchange='changeOptions(this.value)'>";
echo "<option value='' hidden>Select a cohort</option>";
while($row2 = mysqli_fetch_array($result2)) {
	$currentid = $row2['cohortid'];

	echo "<option value='$currentid'"; if(isset($campusid)) {if($campusid==$currentid) {echo " selected";}} echo ">" .$row2['cohortid']."</option>";
}
echo "</select>";

?>
<div id="course">
</div>
</fieldset>

<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='submit'>";$_SESSION['updatingid']=$_SESSION['uid'];}
else {echo "<input type='submit' name='new' value='submit'>";}
  ?>

</form>
</div>
</div>
		</div>
		</div>
<script>
	function changeOptions(cohortid) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("course").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET","../php_script/gettutorcohortcourseform_script.php?cohortid="+cohortid,true);
        xmlhttp.send();
		

    }
	$("#form1").on('submit', function ()
		{
			var flag;
			var d = 5000;
			var tutorid = document.forms["form1"]["tutorid"].value;
			if (tutorid == null || tutorid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Tutor is required");
				flag=false;
			}
			var cohortid = document.forms["form1"]["cohortid"].value;
			if (cohortid == null || cohortid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Cohort is required");
				flag=false;
			}else{
				 var courseid = document.forms["form1"]["courseid"].value;
				 if(courseid == null || courseid == ""){
					 d += 500;
					 alertify.set({	delay: d });
					 alertify.log("Course is requited");
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