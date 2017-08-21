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
	<?php $filename= "user";?>
	<?php $DBtable= "user";?>
	<?php $pkname= "userid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Tutor with Course and Corhort</h1>

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

	$result = "DELETE FROM user WHERE userid='".$deletingid."'";
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
	if(isset($_GET['resetingid']))
	{
		$reset=$_GET['resetingid'];
		$password=sha1("P@ssw0rd");
		$result = "UPDATE user SET password='$password' WHERE userid='$reset'";

		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "The password reset.";
	header('location: ./admin_edituser.php');
	exit();
	}
	else{
		$_SESSION['error'] = "doesn't work reseting.";
		header('location:./admin_edituser.php');
		exit();
	}
		}
		mysqli_close($conn);
?>
<?php include '../php_includes/add.php'; ?>
<div class="tables">
<?php
	include '../php_script/connectDB.php';
	$result = "SELECT * FROM user ";
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
				$userid = $row['userid'];
				$did = json_encode($row['userid']);
				if($row['usertype']==1)
				{
					$usertype="Admin";
				}
				elseif($row['usertype']==0)
				{
					$usertype="User";
				}
				elseif($row['usertype']==2)
				{
					$usertype="Manager";
				}
				else
				{
					$usertype="Undefined";
				}
				echo "<tr value='$userid' class='data'>";
				//echo "<td><a href='./admin_adduser.php?edit=$userid'><img src='../pic/edit.png' /></a> <a href='./admin_adduser.php?copy=$userid'><img src='../pic/copy.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a> <a onclick='resetAction($did)'><img src='../pic/reset.png' /></a></td>";

				echo "<td>" . $userid . "</td>";
				echo "<td>" . $usertype ."</td>";
				echo "<td>" . $row['email'] ."</td>";

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
