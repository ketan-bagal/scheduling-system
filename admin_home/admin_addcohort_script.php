<?php
	session_start();
	include '../php_script/connectDB.php';

	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$cohortid=$_POST['cohortid'];
	$programmeid=$_POST['programmeid'];
	if ($_POST['roomid'] =='') {
    $_POST['roomid'] = 'NULL';
	}
	$roomid=$_POST['roomid'];
	$starttime=$_POST['starttime'];
	$endtime=$_POST['endtime'];
	$semesters=$_POST['semesters'];
	
	if(isset($_POST['submit']))
	{

	$sql = "INSERT INTO cohort(cohortid,programmeid,roomid,starttime,endtime)
				VALUES ('$cohortid','$programmeid',$roomid,'$starttime','$endtime')";
		$result = $conn->query($sql);
	for($i=1;$i<=$semesters;$i++){
		$semesterSD=$_POST['semesterS'.$i];
		$semesterED=$_POST['semesterE'.$i];
		$semestername=$i;
		$sql2 = "INSERT INTO semester(cohortid,startdate,enddate,semestername)
				VALUES ('$cohortid','$semesterSD','$semesterED','$semestername')";
		$result2 = mysqli_query($conn,$sql2);
		if(!$result2){
			break;
		}
	}

		if ( $result&& $result2)
	{
	$_SESSION['error'] = "Cohort added successfully.";
	header('location: ./admin_editcohort.php');
	exit();
	}
	else{
		$_SESSION['error'] = "Failed to add cohort.";
		header('location:./admin_addcohort.php');
		exit();
	}
	}
  mysqli_close($conn);
?>
