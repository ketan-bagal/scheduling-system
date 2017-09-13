<?php
	session_start();
	include '../php_script/connectDB.php';
	
	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	$userid=$_SESSION['userid'];
	
	

	 //edit password
	if(isset($_POST['password'])){
			$currentPassword = $_POST['currentp'];
			$currentPassword = sha1($currentPassword);

			$queryPassword = "SELECT password FROM user WHERE userid='$userid'";
			if($runPassword = $conn->query($queryPassword)){
				$row = mysqli_fetch_array($runPassword);
				$password = $row['password'];
				if($currentPassword != $password){
					$_SESSION['error'] = "Current password is wrong.";
					header('location: ./editpassword.php');
				}else{
					$password = $_POST['newp'];
					$password = sha1($password);

					$result = "UPDATE user SET password='$password' WHERE userid='$userid'";
						
					if ($runquery = $conn->query($result)){
						$_SESSION['error'] = "Password edited successfully.";
						header('location: ./editpassword.php');
						exit();
					}else{
						$_SESSION['errorid'] = $userid;
						$_SESSION['error'] = "Failed to edit password.";
						header('location:./editpassword.php');
						exit();
					}
				}
			}	
	}

	 //edit email
	if(isset($_POST['email'])){
		$email = $_POST['newEmail'];
		$result = "UPDATE user SET email='$email' WHERE userid='$userid'";
		if ($runquery = $conn->query($result)){
			$_SESSION['error'] = "Email edited successfully.";
			header('location: ./editemail.php');
			exit();
		}else{
			$_SESSION['errorid'] = $userid;
			$_SESSION['error'] = "Failed to edit email.";
			header('location:./editemail.php');
			exit();
		}
	}
	
  mysqli_close($conn);
?>
