<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$tutor=$_GET['tutor'];
	

/*  //adding new
	if(isset($_GET['new']))
	{
	$result = "INSERT INTO holiday(holidayname,holidaydate)
				VALUES ('$holidayname','$holidaydate')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "The holiday added.";
	header('location: ./admin_addholiday.php');
	exit();
	}
	else{
		$_SESSION['error'] = "add doesn't work.";
		header('location:./admin_addholiday.php');
		exit();
	}
	} */
	
	//editing
	if(isset($_GET['submit']))
	{
	$result = "UPDATE coursebooking SET tutorid='$tutor' WHERE coursebookingid='$updatingid'";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "The tutor edited.";
	header('location: ./admin_addrecurring.php');
	exit();
	}
	else{
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "edit doesn't work.";
		header('location:./admin_addrecurring.php');
		exit();
	}
	}
  mysqli_close($conn);
?>
