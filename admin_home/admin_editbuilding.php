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
	<?php $title="Edit Building"; ?>
	<?php $filename= "building";?>
	<?php $DBtable= "building";?>
	<?php $pkname= "buildingid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Building</h1>

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
		 $query = "SELECT COUNT(*) as cnt FROM room WHERE buildingid= '".$deletingid."'";
$runquery = mysqli_query($conn, ($query));
$row = mysqli_fetch_array($runquery);
$cnt = $row['cnt'];

if($cnt >= 1)
{
	$_SESSION['error'] = "There is a room for this building. Delete the room first";
	header('location: ./admin_editbuilding.php');
	exit();
 }
	$result = "DELETE FROM building WHERE buildingid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editbuilding.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editbuilding.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
	$result = "SELECT b.*,c.campusname FROM building b,campus c WHERE b.campusid=c.campusid";
		echo "<table id='student_resit' class='border'>
		<thead>
		<tr>
		<th>Building</th>
		<th>Campus</th>
		</tr>
		</thead>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$buildingid = $row['buildingid'];
				$did = json_encode($row['buildingid']);
				echo "<tr value='$buildingid' class='data'>";
				//echo "<td><a href='./admin_addbuilding.php?edit=$buildingid'><img src='../pic/edit.png' /></a> <a href='./admin_addbuilding.php?copy=$buildingid'><img src='../pic/copy.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td contenteditable=\"true\" data-old-value='".$row['buildingname']."' onBlur=\"saveInlineEdit(this,'buildingname','".$row['buildingid']."','building')\" onClick=\"highlightEdit(this);\">".$row['buildingname']."</td>";
				echo "<td >".$row['campusname']."</td>";
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
