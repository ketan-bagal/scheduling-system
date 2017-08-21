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
	<?php $title="Edit Holiday"; ?>
	<?php $filename= "holiday";?>
	<?php $DBtable= "holiday";?>
	<?php $pkname= "holidayid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Holiday</h1>

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
	$result = "DELETE FROM holiday WHERE holidayid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editholiday.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editholiday.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
	$result = "SELECT h.* FROM holiday h";
		echo "<table id='student_resit' class='border'>
		<thead>
		<tr>

		<th>Holiday</th>
		<th>Date (d-m-y)</th>
		</tr>
		</thead>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$holidayid = $row['holidayid'];
				$did = json_encode($row['holidayid']);
				$result = preg_split("/\-/",$row['holidaydate']);
				echo "<tr value='$holidayid' class='data'>";
				//echo "<td><a href='./admin_addholiday.php?edit=$holidayid'><img src='../pic/edit.png' /></a> <a href='./admin_addholiday.php?copy=$holidayid'><img src='../pic/copy.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td>" . $row['holidayname'] ."</td>";
				echo "<td>" . $result[2] ."-". $result[1] ."-". $result[0] ."</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		mysqli_close($conn);
		?>
</div>
</div>
		</div>

<script src="../js/delete_record.js"></script>
<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
