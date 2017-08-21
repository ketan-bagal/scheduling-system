<?php
	session_start();
	include '../php_script/connectDB.php';
	if(isset($_GET['roomid']))
	{
		$roomid = $_GET['roomid'];
	}
	else
	{
		$_SESSION['error'] = "no input selected";
				header('location: ./manager_recurring_view.php');
	}
	
	$result = preg_split("/\!/",$roomid);
				$roomid = $result[0];
				$startdate = $result[1];
				$enddate = $result[2];
				$timeValue = $result[3];
				$trash = $result[4];
				$mon = $result[5];
				$tue = $result[6];
				$wed = $result[7];
				$thu = $result[8];
				$fri = $result[9];
				$sat = $result[10];
				$tutor = $result[12];
				$course = $result[11];
	if(isset($_GET['time'.$timeValue]))
	{
		$times = $_GET['time'.$timeValue];
		if($times[0]!=null)
		{
		$endtime = strtotime($times[sizeof($times)-1]);
		$endtime = date("H:i", strtotime('+30 minutes',$endtime));
		$starttime = $times[0];
		}
		}
		
	$result = "INSERT INTO coursebooking(startdate,enddate,coursename,classstarttime,classendtime,roomid,daySat,dayMon,dayTue,dayWed,dayThu,dayFri,tutorid)
				VALUES ('$startdate','$enddate','$course','$starttime','$endtime','$roomid','$sat','$mon','$tue','$wed','$thu','$fri','$tutor')";
	if ($runquery = $conn->query($result))
	{
		
		
		
		
			$_SESSION['error'] = "booking made.";
			header('location: ./manager_recurring_view.php');
			exit();
		}
		

	if(!$runquery){
		$_SESSION['error'] = "couldnt add booking";
		header('location:./manager_recurring_view.php');
		exit();
	}