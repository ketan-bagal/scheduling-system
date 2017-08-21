<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$campusname=$_POST['campusname'];
	$address=$_POST['address'];
	

	//adding new
	if(isset($_POST['new']))
	{
	
	$result = "INSERT INTO campus(campusname,address)
				VALUES ('$campusname','$address')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Campus added successfully.";
	header('location: ./admin_editcampus.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add campus.";
		header('location:./admin_addcampus.php');
		exit();
	}
	}
	//editing
	if(isset($_POST['submit']))
	{
	$result = "UPDATE campus SET campusname='$campusname',address='$address' WHERE campusid='$updatingid'";
		
		if ($runquery = $conn->query($result))
	{
		
	$_SESSION['error'] = "The campus edited.";
	header('location: ./admin_addcampus.php');
	exit();
	}
	else{
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "doesn't work.";
		header('location:./admin_addcampus.php');
		exit();
	}
	}
  mysqli_close($conn);
?>
