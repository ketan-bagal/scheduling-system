<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$email=$_POST['email'];
	

 //adding new
	if(isset($_POST['new']))
	{
		
		$firstname=trim($firstname," ");
		$lastname=trim($lastname," ");
		$email=trim($email," ");
		//Regex exper=new Regex(@"\s+");
		//var re = /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/;
		
		$pattern = '/\s{2,}/i';
		$replacement = ' ';
		$firstname = preg_replace($pattern, $replacement, $firstname);
		$lastname = preg_replace($pattern, $replacement, $lastname);
	$result = "INSERT INTO tutor(lastname,firstname,email)
				VALUES ('$lastname','$firstname','$email')";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Tutor added successfully.";
	header('location: ./admin_edittutor.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add tutor.";
		
		header('location:./admin_addtutor.php');
		exit();
	}
	}
	//editing
	if(isset($_POST['submit']))
	{
	$result = "UPDATE tutor SET firstname='$firstname',lastname='$lastname',email='$email' WHERE tutorid='$updatingid'";
		
		if ($runquery = $conn->query($result))
	{
	$_SESSION['error'] = "Tutor edited successfully.";
	header('location: ./admin_edittutor.php');
	exit();
	}
	else{
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "Failed to edit Tutor.";
		
		header('location:./admin_addtutor.php');
		exit();
	}
	}
  mysqli_close($conn);
?>
