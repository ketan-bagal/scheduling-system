<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	
	$programmeid=$_POST['programmeid'];
	$campusid=$_POST['campusid'];
	//adding new
	if(isset($_POST['submit']))
	{
	
	$result = "INSERT INTO campus_programme(programmeid,campusid)
				VALUES ('$programmeid','$campusid')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Define CampusProgramme successfully.";
	header('location: ./admin_editcampusprogramme.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to define CampusProgramme.";
		header('location:./admin_addcampusprogramme.php');
		exit();
	}
	}
  mysqli_close($conn);
?>