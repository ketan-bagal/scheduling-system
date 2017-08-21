<?php session_start(); ?>
<?php 
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 2){
		header('location:../error_page.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Edit Booking"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Booking</h1>	
			
<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{	
					print $_SESSION['error'];	
					unset($_SESSION['error']);
				}
				
		?>
</div><!--error--><br />
<div class="tables">
<?php
include '../php_script/connectDB.php';
	if(isset($_GET['deletingid']))
	{
	$deletingid=$_GET['deletingid'];
	unset($_GET['deletingid']);
	$result = "DELETE FROM booking WHERE bookingid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
				
			$result = "DELETE FROM bookinginfo WHERE bookingid='".$deletingid."'";
			if($runquery=mysqli_query($conn,$result))
			{
				$_SESSION['error'] = "updated successfully";
			header('location: ./manager_editbooking.php');
			exit();
			}
			if(!$runquery)
			{
					$_SESSION['error'] = "booking info query wrong";
			header('location: ./manager_editbooking.php');
			exit();
			}
			
			}
			else
			{
			
				$_SESSION['error'] = "query wrong";
			header('location: ./manager_editbooking.php');
			exit();
			}
	}
	if(isset($_GET['confirmingid']))
	{
	$confirmingid=$_GET['confirmingid'];
	
	$result = "UPDATE booking SET bookingstatus = 'confirmed' WHERE bookingid='".$confirmingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			include '../sendEmail.php';
			unset($_GET['confirmingid']);
			$_SESSION['error'] = "updated successfully";
			header('location: ./manager_editbooking.php');
			exit();
			}
			else
			{
			unset($_GET['confirmingid']);
				$_SESSION['error'] = "query wrong";
			header('location: ./manager_editbooking.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
	$data = array();
	$childCnt = 0;
	$result = "SELECT r.* FROM booking r WHERE r.bookinguserid='".$_SESSION['userid']."'";
		echo "<table id='student_resit' class='border'>
		<tr>
		<th></th>
		<th>Room</th>
		<th>Location</th>
		<th>Booking</th>
		<th>User</th>
		<th>Reason</th>
		<th>Status</th>
		</tr>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$data[$row["bookingid"]]["bookingid"] = $row["bookingid"];
				$data[$row["bookingid"]]["bookinguserid"] = $row["bookinguserid"];
				$data[$row["bookingid"]]["bookingstatus"] = $row["bookingstatus"];
				$data[$row["bookingid"]]["reason"] = $row["reason"];
				$data[$row["bookingid"]]["date"] = $row["date"];
			
					$childQuery = "SELECT h.*,booking.*,room.roomname,b.buildingname,campus.campusname FROM booking,bookinginfo h,building b,campus,room WHERE h.bookingid='".$row['bookingid']."' AND room.roomid = h.roomid AND room.buildingid = b.buildingid AND campus.campusid = b.campusid";
					if($runChildQuery = $conn->query($childQuery))
					{
						
						while($row2 = $runChildQuery->fetch_assoc())
						{
							
							$data[$row["bookingid"]]["child"][$row2["bookinginfoid"]]['time']=$row2["time"];
							$data[$row["bookingid"]]["child"][$row2["bookinginfoid"]]['roomid']=$row2["roomid"];
							$data[$row["bookingid"]]["child"][$row2["bookinginfoid"]]['roomname']=$row2["roomname"];
							$data[$row["bookingid"]]["child"][$row2["bookinginfoid"]]['buildingname']=$row2["buildingname"];
							$data[$row["bookingid"]]["child"][$row2["bookinginfoid"]]['campusname']=$row2["campusname"];
							$childCnt++;
							
						}
					}
					
					if(!$runChildQuery)
					{
						
						 $_SESSION['error'] = "child room Query error: ".mysqli_error($conn);
						 header('location: ./manager_editbooking.php');
						 exit();
						 
					}	
				
			}
		}
		if(!$runquery)
		{
			$_SESSION['error'] = mysqli_error($conn);
			header('location: ./manager_editbooking.php');
			exit();
			
		}
		if($childCnt!=0)
		{
		foreach($data as $value)
			{
		$bookingid = $value['bookingid'];
				$did = json_encode($bookingid);
				echo "<tr>";
				echo "<td><a href='javascript:deleteAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td>";
				foreach($value["child"] as $subkey)
					{
					echo $subkey['roomname'],"<br>\n";
					}
				
				echo "</td>";
				echo "<td>";
				foreach($value["child"] as $subkey)
					{
					echo $subkey['buildingname']," / ".$subkey['campusname']."<br>\n";
					}
				
				echo "</td>";
				
				echo "<td>" . $value['date'] ." / ";
				foreach($value["child"] as $subkey)
					{
					echo $subkey["time"]."<br>\n";
					}
				
				echo "</td>";
				
				echo "<td>" . $value['bookinguserid'] ."</td>";
				echo "<td>" . $value['reason'] ."</td>";
				echo "<td>" . $value['bookingstatus'] ."</td>";
				
				echo "</tr>";
			}
		}
		echo "</table>";
		mysqli_close($conn);
		?>
</div>
</div>
		</div>
<script>
function confirmAction (id) {
    var did=id;
	alertify.confirm('Are you sure you wish to confirm '+did+'?', function(e) {
        if (e) {
			
            window.location.href = "./manager_editbooking.php?confirmingid=" + did; 
            }
   
    });
}
function deleteAction (id) {
    var did=id;
	alertify.confirm('Are you sure you wish to delete '+did+'?', function(e) {
        if (e) {
			
            window.location.href = "./manager_editbooking.php?deletingid=" + did; 
            }
   
    });
}
</script>

<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</body>
</html>