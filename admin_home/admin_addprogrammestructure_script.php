<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	
	$programmeid=$_POST['programmeid'];
	
	$semesters = $_POST['semesters'];
	for($semester=1;$semester<=$semesters;$semester++){
		$coursenum = 1;
		while(isset($_POST[$semester.$coursenum])){
			$courseid = $_POST[$semester.$coursenum];
			$priority = $semester.$coursenum;
			if($courseid == "0"){
				$courseid = $_POST[$semester.$coursenum.'ex'];
			}
			if(isset($_POST['submit']))
		{
			$sql = "INSERT INTO programme_course(courseid,programmeid,semester,priority)
				VALUES ('$courseid','$programmeid','$semester','$priority')";
			$result = mysqli_query($conn,$sql);
			if(!$result){
				$_SESSION['error'] = "Failed to define programme.";
				header('location:./admin_addprogrammestructure.php');
				exit();
			}
		}
			$coursenum++;
		}
	}
	if(isset($_POST['submit']))
	{
		
	if ($result)
	{
	$_SESSION['error'] = "Define programme successfully.";
	header('location: ./admin_editcourseprogramme.php');
	exit();
	}
	
	}

  mysqli_close($conn);
?>