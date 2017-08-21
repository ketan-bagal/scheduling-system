<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$schoolname=$_POST['schoolname'];
	
	
	//adding new
	if(isset($_POST['submit']))
	{
	
	$result = "INSERT INTO school(name)
				VALUES ('$schoolname')";
		
		if ($runquery = $conn->query($result))
	{
		$_SESSION['error'] = "School added successfully.";
		header('location: ./admin_editschool.php');
		exit();
	}
	else{
		$_SESSION['error'] = "Failed to add school.";
		echo $schoolname;
		header('location:./admin_addschool.php');
		exit();
	}
	}
	//editing
	if(isset($_POST['new']))
	{
	$result = "UPDATE school SET schoolname='$schoolname' WHERE schoolid='$updatingid'";
		
		if ($runquery = $conn->query($result))
	{
		
	$_SESSION['error'] = "The campus edited.";
	header('location: ./admin_addcampus.php');
	exit();
	}
	else{
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "doesn't work.";
		header('location:./admin_addschool.php');
		exit();
	}
	}
  mysqli_close($conn);
?>