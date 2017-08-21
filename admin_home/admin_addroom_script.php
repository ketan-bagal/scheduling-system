<?php
	session_start();
	include '../php_script/connectDB.php';

	if(isset($_SESSION['updatingid']))
	{
		$updatingid=$_SESSION['updatingid'];
	}
	if(isset($_GET['askareas']))
	{$childnum=$_GET['askareas'];
	}
	$roomname=$_POST['roomname'];
	$capacity=$_POST['capacity'];
	$buildingid=$_POST['buildingid'];
	$FixedResources=$_POST['resources'];
	$floornumber=$_POST['floornumber'];
	$roomtype = $_POST['roomtype'];
	$disability = $_POST['disability'];

	if($roomtype == 1)
	{
		for($i = 1; $i <= $childnum;$i++)
		{
			${"roomname".$i}=$_GET['roomname'.$i];
			${"capacity".$i}=$_GET['capacity'.$i];
			${"FixedResources".$i}=$_GET['resources'.$i];
		}
	}
	//checking capacity
	if($roomtype == 1)
	{
		$sum=0;
		for($i = 1; $i <= $childnum;$i++)
		{
			$sum+=${"capacity".$i};
		}
		if($capacity<$sum)
		{

			$_SESSION['error'] = "Areas have more capacity overall than room's.";
			if(isset($_POST['submit']))
			{

				header('location: ./admin_editmulti.php');
				exit();
			}
			else
			{
				for($i = 1; $i <= $childnum;$i++)
				{

					$_SESSION['roomname'.$i]=${"roomname".$i};
					$_SESSION['capacity'.$i]=${"capacity".$i};

					$_SESSION['FixedResources'.$i]=${"FixedResources".$i};
				}
				$_SESSION['childnum'] = $childnum ;
					$_SESSION['addingfailid'] = $updatingid;
					$_SESSION['roomname'] = $roomname;

					$_SESSION['capacity'] = $capacity;
					$_SESSION['disability'] = $disability;
					$_SESSION['FixedResources'] = $FixedResources;
					$_SESSION['floornumber'] = $floornumber;
					$_SESSION['buildingid'] = $buildingid;
					header('location: ./admin_addroom.php');
			}
			exit();
		}
	}

//checking building id
	$query = "SELECT COUNT(*) as cnt FROM building WHERE building.buildingid= '".$buildingid."'";
$runquery = mysqli_query($conn, ($query));
if($runquery){
$row = mysqli_fetch_array($runquery);
$cnt = $row['cnt'];
}
else
{
	$_SESSION['error'] = "error checking building id.";
		header('location:./admin_addroom.php');
		exit();
}
if($cnt < 1)
{
	$_SESSION['error'] = "There is no such building id.";
	$_SESSION['lead'] = "<br><a href='./admin_editbuilding.php'>click here to register the building id</a>";
	header('location: ./admin_addroom.php');
	exit();
 }
	//adding new
	if(isset($_POST['new']))
	{

	$result = "INSERT INTO room(roomname,buildingid,floornumber,capacity,roomtype,disability,fixedresources)
				VALUES ('$roomname','$buildingid','$floornumber','$capacity','$roomtype','$disability','$FixedResources')";

		if ($runquery = $conn->query($result))
	{
		if($roomtype == 1)
		{
			$result2 = "SELECT b.roomid FROM room b where b.buildingid = '$buildingid' AND b.roomname = '$roomname' AND b.roomtype='$roomtype' AND b.fixedResources='$FixedResources' AND b.capacity='$capacity' AND b.floornumber='$floornumber'";
		if ($runquery = $conn->query($result2))
		{
			while($row = $runquery->fetch_assoc())
			{
			$roomid = $row['roomid'];
			}
		}
			for($i = 1; $i <= $childnum;$i++)
		{
			$multiroomchildid = $roomid.".".$i;
			$query = "INSERT INTO multiroomchild(multiroomchildid,capacity,roomid,roomname,fixedresources)
						VALUES ('$multiroomchildid','".${"capacity".$i}."','$roomid','".${"roomname".$i}."','".${"FixedResources".$i}."')";
			$runquery = mysqli_query($conn, ($query));
			if(!$runquery)
			{
				$_SESSION['error'] = "The areas could nott be add";
				header('location: ./admin_addroom.php');
				exit();
			}

		}
		}
	$_SESSION['error'] = "Room added successfully.";
	header('location: ./admin_editroom.php');
	exit();
	}
	if(!$runquery){

		$_SESSION['error'] = "Failed to add room.";
		header('location:./admin_addroom.php');
		exit();
	}

	}
	//editing
	if(isset($_POST['submit']))
	{
		$count=0;$countb=0;
		if($roomtype==1)
		{
			$deleteChild = "DELETE FROM multiroomchild WHERE roomid='$updatingid'";
			if ($runquery = $conn->query($deleteChild))
					{

					}
					if(!$runquery)
					{
						$_SESSION['errorid'] = $updatingid;
						$_SESSION['error'] = "couldn't delete  area.";
						header('location:./admin_editmulti.php');
						exit();
					}
		for($i = 1; $i <= $childnum;$i++)
		{
	$multiroomchildid = $updatingid.".".$i;
			$insertChild = "INSERT INTO multiroomchild(multiroomchildid,capacity,roomid,roomname,fixedresources)
						VALUES ('$multiroomchildid','".${"capacity".$i}."','$updatingid','".${"roomname".$i}."','".${"FixedResources".$i}."')";
					if ($runquery = $conn->query($insertChild))
					{
					}
					if(!$runquery)
					{
						$_SESSION['errorid'] = $updatingid;
						$_SESSION['error'] = "couldn't insert to update  area.";
						header('location:./admin_editmulti.php');
						exit();
					}
		}
		}
	$result = "UPDATE room SET roomname='$roomname',capacity='$capacity',floornumber='$floornumber',buildingid='$buildingid',roomtype='$roomtype',disability='$disability',fixedresources='$FixedResources' WHERE roomid='$updatingid'";

		if ($runquery = $conn->query($result))
	{

	$_SESSION['error'] = "The room edited.";
	header('location: ./admin_addroom.php');
	exit();
	}
	if(!$runquery){
		$_SESSION['errorid'] = $updatingid;
		$_SESSION['error'] = "the room coulnt be edited.";
		header('location:./admin_addroom.php');
		exit();
	}
	}


  mysqli_close($conn);
?>
