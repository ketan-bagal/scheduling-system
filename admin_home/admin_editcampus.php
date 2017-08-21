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
	<?php $title="Edit campus"; ?>
	<?php $filename= "campus";?>
	<?php $DBtable= "campus";?>
	<?php $pkname= "campusid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Campus</h1>

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
		 $query = "SELECT COUNT(*) as cnt FROM building WHERE campusid= '".$deletingid."'";
$runquery = mysqli_query($conn, ($query));
$row = mysqli_fetch_array($runquery);
$cnt = $row['cnt'];

if($cnt >= 1)
{
	$_SESSION['error'] = "There is a building for this campus. Delete the building first";
	header('location: ./admin_editcampus.php');
	exit();
 }
	$result = "DELETE FROM campus WHERE campusid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editcampus.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editcampus.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
	$result = "SELECT c.* FROM campus c";
		echo "<table id='student_resit' class='border'>
		<thead>
		<tr>
		<th>Campus</th>
		<th>Address</th>
		</tr>
		</thead>";
		$runquery = $conn->query($result);
		if (!$runquery)
		{
			die('Invalid query: ' . mysqli_error($conn));
		}
		else
		{
			while($row = $runquery->fetch_assoc())
			{
				$campusid = $row['campusid'];
				$did = json_encode($row['campusid']);
				echo "<tr value='$campusid' class='data'>";
				//echo "<td><a href='./admin_addcampus.php?edit=$campusid'><img src='../pic/edit.png' /></a> <a href='./admin_addcampus.php?copy=$campusid'><img src='../pic/copy.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";

				echo "<td contenteditable=\"true\" data-old-value='".$row['campusname']."' onBlur=\"saveInlineEdit(this,'campusname','".$row['campusid']."','campus')\" onClick=\"highlightEdit(this);\">" . $row['campusname']."</td>";
				echo "<td contenteditable=\"true\" data-old-value='".$row['address']."' onBlur=\"saveInlineEdit(this,'address','".$row['campusid']."','campus')\" onClick=\"highlightEdit(this);\">" . $row['address'] ."</td>";

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
