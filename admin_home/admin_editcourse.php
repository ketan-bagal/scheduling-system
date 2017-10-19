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
	<?php $title="Edit Course"; ?>
	<?php $filename= "course";?>
	<?php $DBtable= "course";?>
	<?php $pkname= "courseid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Course</h1>

<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}

		?>
</div><!--error--><br />
<?php include '../php_includes/add.php'; ?>
<div class="tables">
<?php
include '../php_script/connectDB.php';
	if(isset($_GET['deletingid']))
	{
	$deletingid=$_GET['deletingid'];
	unset($_GET['deletingid']);
	$result = "DELETE FROM course WHERE courseid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editcourse.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editcourse.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
	$result = "SELECT course.*, programme.name AS programmename FROM course INNER JOIN programme ON course.programmeid=programme.programmeid";
		echo "<table id='student_resit' class='border'>
		<thead><tr>
	
		<th>Course</th>
		<th>Programme</th>
    <th>Credits</th>
    <th>Duration</th>
		<th>Level</th>
		</tr>
		</thead>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$courseid = $row['courseid'];
				$did = json_encode($row['courseid']);
				echo "<tr value='$courseid' class='data'>";
				//echo "<td><a href='./admin_addcourse.php?edit=$courseid'><img src='../pic/edit.png' /></a> <!--<a href='./admin_addcourse.php?copy=$courseid'><img src='../pic/copy.png' /></a>--> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td>" . $row['name'] ."<img style='display:none; position:relative; left:10%;' onclick='confirmAction (\"$tutorid\",\"$DBtable\",\"$pkname\");' class = 'button_delete' height='20px' width='20px' src='../pic/delete.png' /></td>";
				echo "<td>" . $row['programmename'] ."</td>";
        echo "<td>" . $row['credits'] ."</td>";
        echo "<td>" . $row['duration'] ."&nbsp week(s)</td>";
				echo "<td>" . $row['level'] ."</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		mysqli_close($conn);
		?>
</div>
</div>
		</div>
<script src="../js/delete_row.js"></script>

<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
