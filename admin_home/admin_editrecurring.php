<?php session_start(); ?>
<?php 
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
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
	$result = "DELETE FROM coursebooking WHERE coursebookingid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "updated successfully";
			header('location: ./admin_editrecurring.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editrecurring.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
	$result = "SELECT c.*,room.roomname,b.buildingname,campus.campusname,tutor.* FROM coursebooking c,building b,campus,room,tutor WHERE c.tutorid=tutor.tutorid AND room.roomid = c.roomid AND room.buildingid = b.buildingid AND campus.campusid = b.campusid";
		echo "<table id='student_resit' class='border'>
		<tr>
		<th></th>
		<th>Room</th>
		<th>Location</th>
		<th>Booking</th>
		<th>Days</th>
		<th>Tutor</th>
		</tr>";
		if ($runquery = $conn->query($result))
		{
			$day = array("Mon","Tue","Wed","Thu","Fri","Sat");
			$count=0;
			while($row = $runquery->fetch_assoc())
			{
				$holidayid = $row['coursebookingid'];
				$did = json_encode($row['coursebookingid']);
				echo "<tr>";
				echo "<td><a href='./admin_addrecurring.php?edit=$holidayid'><img src='../pic/edit.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td>" . $row['roomname'] ." - (";
				echo $row['roomid'] .")</td>";
				echo "<td>" . $row['buildingname'] ." / ". $row['campusname']."</td>";
				echo "<td>";
					echo $row['coursename'];
					echo "<br>\n";
					echo $row['startdate'] ." - ". $row['enddate']."<br>\n";
					echo $row['classstarttime'] ." - ". $row['classendtime']."</td>";
				echo "<td>";
				if($row['dayMon']==1) echo "Mon ";if($row['dayTue']==1) echo "Tue ";if($row['dayWed']==1) echo "Wed ";if($row['dayThu']==1) echo "Thu ";if($row['dayFri']==1) echo "Fri ";if($row['daySat']==1) echo "Sat ";
				echo "</td>";
				echo "<td>";
				echo $row['firstname']." ".$row['lastname'];
				echo "</td>";
				echo "</tr>";
			}
		}
		if(!$runquery)
		{
			$_SESSION['error'] = mysqli_error($conn);
			
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
	alertify.confirm('Are you sure you wish to delete '+did+'?', function(e) {
        if (e) {
			
            window.location.href = "./admin_editrecurring.php?deletingid=" + did; 
            }
   
    });
}
</script>

<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</body>
</html>