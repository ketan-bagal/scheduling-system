<?php session_start(); ?>
<?php
include './connectDB.php';
//Create the query
$query = "SELECT * FROM user";

//Run the query
$runquery = mysqli_query($conn, $query);

//Compare the results with the login information
$username = trim($_POST['uname']);
$password = sha1($_POST['passwd']);

if(empty($username)||empty($password))
{
	$_SESSION["error"] = "Please fill in all fields";
	header('location: ../index.php');
	exit();
}
if(!$runquery)
{
	die('Invalid query: ' . mysqli_error());
}
else
{
	while($row = mysqli_fetch_assoc($runquery))
	{
		if($username == $row['userid'] && $password == $row['password'])
		{
			$_SESSION["userid"] = $row['userid'];
			$_SESSION["usertype"] = $row['usertype'];

			if($row['usertype']== 1)
			{
				header('location: ../admin_home/admin_editcohort.php'); 
				exit();
			}
			if($row['usertype']== 0)
			{
				header('location: ../user_home/user_home.php');
				exit();
			}
			if($row['usertype']== 2)
			{
				header('location: ../manager_home/manager_home.php');
				exit();
			}
		}
	}
}

// Close the connection to the server
mysqli_close($conn);
$_SESSION["error"] = "Wrong username or password, please try again.";
header('location: ../index.php');

?>
