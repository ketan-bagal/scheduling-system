<?php
	session_start();
	include '../php_script/connectDB.php';
	$userid = $_SESSION["userid"];
	$cnt = 0;
	if(isset($_GET['time']))
	{
		$time = array();
		$time = $_GET['time'];
		$reason = $_GET['reason'];

	}
	else
	{
		$_SESSION['errorid'] = "no input selected";
				header('location: ./call.php');
	}
	$day=$_SESSION['day'];
	$month =$_SESSION['month'];
	if(!isset($month[1]))
	{
		$month[1] = $month[0];
		$month[0] = "0";
	}
	if(!isset($day[1]))
	{
		$day[1] = $day[0];
		$day[0] = "0";
	}
	$year =$_SESSION['year'];
	$date = $year."-".$month."-".$day;
	
	
	$result = "INSERT INTO booking(bookinguserid,bookingstatus,reason,date)
				VALUES ('$userid','pending', '$reason','$date')";
	if ($runquery = $conn->query($result))
	{
		$result2 = "SELECT b.bookingid FROM booking b where b.bookinguserid = '$userid' AND b.reason = '$reason' AND b.date='$date'";
		if ($runquery = $conn->query($result2))
		{
			while($row = $runquery->fetch_assoc())
			{
			$bookingid = $row['bookingid'];
			$cnt++;
			}
			foreach($time as $temp)
			{
				$result = preg_split("/\-/",$temp);
				$temp = $result[0];
				$roomid = $result[1];
			$result3 = "INSERT INTO bookinginfo(bookingid,roomid,time)
				VALUES ('$bookingid', '$roomid','$temp')";
				if ($runquery = $conn->query($result3))
				{
				}
				if(!$runquery){
			$_SESSION['error'] = "failed to addd booking info";
			header('location:./call.php');
			exit();
			}
			
			}
					$_SESSION['error'] = "booking made.";
			header('location: ./call.php');
			exit();
		}
		if(!$runquery){
			$_SESSION['error'] = "couldnt get bookingid from booking";
			header('location:./call.php');
			exit();
		}
	}
		

	if(!$runquery){
		$_SESSION['error'] = "couldnt add booking";
		header('location:./call.php');
		exit();
	}