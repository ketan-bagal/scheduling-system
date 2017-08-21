<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$courseid=$_POST['courseid'];
	$programmeid=$_POST['programmeid'];
	
	$years=$_POST['duryear'];
	$weeks=$_POST['durweek'];
	$duration = $years*51+$weeks;
	$credits=$_POST['credits'];
	$coursename=$_POST['coursename'];
	$level=$_POST['level'];
	//adding new
	if(isset($_POST['submit']))
	{
	
	$result = "INSERT INTO course(courseid,programmeid,duration,name,credits,level)
				VALUES ('$courseid','$programmeid','$duration','$coursename','$credits','$level')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Course added successfully.";
	header('location: ./admin_editcourse.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add course.";
		header('location:./admin_addcourse.php');
		exit();
	}
	}
  mysqli_close($conn);
?>