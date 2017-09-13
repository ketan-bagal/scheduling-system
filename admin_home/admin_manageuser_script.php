<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$usertype=$_POST['usertype'];
	$userid=$_POST['userid'];
	
	

	 //adding new
	if(isset($_POST['submit'])){
			//checking user id
		$query = "SELECT COUNT(*) as cnt FROM user WHERE userid= '".$userid."'";
		$runquery = mysqli_query($conn, ($query));
		$row = mysqli_fetch_array($runquery); 
		$cnt = $row['cnt'];

		if($cnt == 0)
		{
			$_SESSION['errorid'] = $userid;
			$_SESSION['error'] = "The user id doesn't exists.";
			header('location: ./admin_manageuser.php');
			exit();
		}else{
			$password="password";
			$password = sha1($password);
			$result = "";
			if(isset($_POST['reset'])){
				$result = "UPDATE user SET usertype='$usertype',password='$password' WHERE userid='$userid'";
			}else{
				$result = "UPDATE user SET usertype='$usertype' WHERE userid='$userid'";
			}
				
			if ($runquery = $conn->query($result)){
				$_SESSION['error'] = "User edited successfully.";
				header('location: ./admin_edituser.php');
				exit();
			}else{
				$_SESSION['errorid'] = $userid;
				$_SESSION['error'] = "Failed to edit user.";
				header('location:./admin_manageuser.php');
				exit();
			}
			
		}
	}
  mysqli_close($conn);
?>
