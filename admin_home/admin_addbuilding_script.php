<?php
	session_start();
	include '../php_script/connectDB.php';

	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$buildingname=$_POST['buildingname'];
	$campusid=$_POST['campusid'];

	//checking campus id
/*$query = "SELECT COUNT(*) as cnt FROM campus WHERE campus.campusid= '".$campusid."'";
$runquery = mysqli_query($conn, ($query));
if($runquery){
$row = mysqli_fetch_array($runquery);
$cnt = $row['cnt'];
}
else
{
	$_SESSION['error'] = "query.";
		header('location:./admin_addbuilding.php');
		exit();
}
if($cnt < 1)
{
	$_SESSION['error'] = "There is no such campus id.";
	$_SESSION['lead'] = "<br><a href='./admin_editcampus.php'>click here to register the campus id</a>";
	header('location: ./admin_addbuilding.php');
	exit();
 }
*/
 //adding new
	if(isset($_POST['new']))
	{
	$result = "INSERT INTO building(buildingname,campusid)
				VALUES ('$buildingname','$campusid')";

		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Building added successfully.";
	header('location: ./admin_editbuilding.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add building.";
		header('location:./admin_addbuilding.php');
		exit();
	}
	}
	//editing
	if(isset($_GET['submit']))
	{
	$result = "UPDATE building SET buildingname='$buildingname',campusid='$campusid' WHERE buildingid='$updatingid'";

		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "The building edited.";
	header('location: ./admin_addbuilding.php');
	exit();
	}
	else{
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "doesn't work.";
		header('location:./admin_addbuilding.php');
		exit();
	}
	}
  mysqli_close($conn);
?>
