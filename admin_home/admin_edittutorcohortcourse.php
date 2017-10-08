<?php session_start(); ?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Edit user"; ?>
	<?php $filename= "tutorcohortcourse";?>
	<?php $DBtable= "tutor_cohort_course";?>
	<?php $pkname= "id";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Tutor <img src='../pic/link.png' alt='link' style='width:20px;height:20px;'> Course</h1>

<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}

		?>
</div><!--error--><br />
<?php
include '../php_script/connectDB.php';
	if(isset($_GET['deletingid']))
	{
	$deletingid=$_GET['deletingid'];

	$result = "DELETE FROM tutor_cohort_course WHERE id='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_edituser.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_edituser.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php include '../php_includes/add.php'; ?>
<div class="tables">
<?php
	include '../php_script/connectDB.php';
		$result = "SELECT * FROM tutor_cohort_course ";
		echo "<table id='student_resit' class='border'>
		<col span='1' class='wide'>
		<thead>
		<tr>

		<th>Tutor Name</th>
		<th>Corhort</th>
		<th>Course</th>
		</tr>
		</thead>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$id = $row['id'];
				$tutorid = $row['tutorid'];
				$sql_tutor = "SELECT CONCAT(firstname,' ', lastname) AS name FROM tutor WHERE tutorid = $tutorid";
				$result_tutor = mysqli_query($conn,$sql_tutor);
				$row_tutor = mysqli_fetch_array($result_tutor);
				$tutorname = $row_tutor['name'];
				$cohortid = $row['cohortid'];
				$courseid = $row['courseid'];
				$sql_course = "SELECT name FROM course WHERE courseid = '$courseid'";
				$result_course = mysqli_query($conn,$sql_course);
				$row_course = mysqli_fetch_array($result_course);
				$coursename = $row_course['name'];
				echo "<tr value='$id' class='data'>";
				//echo "<td><a href='./admin_adduser.php?edit=$userid'><img src='../pic/edit.png' /></a> <a href='./admin_adduser.php?copy=$userid'><img src='../pic/copy.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a> <a onclick='resetAction($did)'><img src='../pic/reset.png' /></a></td>";

				echo "<td>" . $tutorname . "</td>";
				echo "<td>" . $cohortid ."</td>";
				echo "<td>" . $coursename ."</td>";

				echo "</tr>";
			}
		}
		echo "</table>";
		mysqli_close($conn);
		?>
</div>
</div>
</div>

		<script>
function resetAction (id) {
    var did=id;
	alertify.confirm('Are you sure you wish to reset password for '+did+'?', function(e) {
        if (e) {

            window.location.href = "./admin_edituser.php?resetingid=" + did;
            }

    });
}
</script>
<script src="../js/delete_record.js"></script>
<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
