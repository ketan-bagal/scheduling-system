<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$holidayname=$_POST['holidayname'];
	$holidaydate1=$_POST['holidaydate'];
	$date = date_create($holidaydate1);
	$holidaydate=date_format($date,"Y/m/d");
	

 //adding new
	if(isset($_POST['new']))
	{
	$result = "INSERT INTO holiday(holidayname,holidaydate)
				VALUES ('$holidayname','$holidaydate')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Holiday added successfully.";
	header('location: ./admin_addholiday.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add holiday.";
		header('location:./admin_addholiday.php');
		exit();
	}
	}
	//editing
	if(isset($_POST['submit']))
	{
	$result = "UPDATE holiday SET holidayname='$holidayname',holidaydate='$holidaydate' WHERE holidayid='$updatingid'";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Holiday edited successfully.";
	header('location: ./admin_editholiday.php');
	exit();
	}
	else{
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "Failed to edit holiday.";
		header('location:./admin_addholiday.php');
		exit();
	}
	}
  mysqli_close($conn);
?>
