<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$schoolid=$_POST['schoolid'];
	$programmename=$_POST['programmename'];
	$credits=$_POST['credits'];
	$years=$_POST['duryear'];
	$weeks=$_POST['durweek'];
	$duration = $years*52+$weeks;
	$semesters = $_POST['semesters'];
	$level = $_POST['level'];
	$classdur = $_POST['classdur'];
	//adding new
	if(isset($_POST['submit']))
	{
	
	$result = "INSERT INTO programme(schoolid,duration,name,credits,semesters,level,classDuration)
				VALUES ('$schoolid','$duration','$programmename','$credits','$semesters','$level','$classdur')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Programme added successfully.";
	header('location: ./admin_editprogramme.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add programme.";
		header('location:./admin_addprogramme.php');
		exit();
	}
	}
  mysqli_close($conn);
?>