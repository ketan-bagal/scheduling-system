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
	<?php $title="View Report"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>View Report</h1>
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
<table id='student_resit' class='border'>
			<tr>
			<th width = '220px' nowrap></th>
			<th>percent (divided by total booking hours)</th>
			</tr>
<?php
include '../php_script/connectDB.php';
$total = 0;
$query = "SELECT * FROM coursebooking";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_array($result)) {
$date1 = $row['startdate'];
$date2 = $row['enddate'];
$diff = strtotime($date2) - strtotime($date1);
$total += $diff/3600;

}
	$query = "SELECT * FROM booking, bookinginfo b WHERE b.bookingid=booking.bookingid AND booking.bookingstatus != 'cancelled'";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_array($result)) {

$total += .5;

}

$rooms = array();
$sql="SELECT * FROM room";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)) {
	if($row["roomtype"]==1)
				{
					$childQuery = "SELECT m.roomname,m.multiroomchildid FROM multiroomchild m WHERE m.roomid='".$row["roomid"]."'";
					if(($childrunquery = $conn->query($childQuery)) )
					{
					while($row2 = $childrunquery->fetch_assoc())
					{
						$rooms[$row2["multiroomchildid"]]["name"] = $row2["roomname"];
						$rooms[$row2["multiroomchildid"]]["id"] = $row2["multiroomchildid"];
						$rooms[$row2["multiroomchildid"]]["type"] = $row["roomtype"];
					}
					}
					if(!$childrunquery)
					{
						 $_SESSION['error'] = "Query error: ".mysqli_error($conn);
					}
				}
				else
				{
				$rooms[$row["roomid"]]["name"] = $row["roomname"];
				$rooms[$row["roomid"]]["id"] = $row["roomid"];
				}
}
foreach($rooms as $value)
{
	$diff_in_hrs=0;
	$roomid = $value['id'];
	$query = "SELECT * FROM coursebooking WHERE roomid = '$roomid'";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_array($result)) {
$date1 = $row['startdate'];
$date2 = $row['enddate'];
$diff = strtotime($date2) - strtotime($date1);
$diff_in_hrs += $diff/3600;

}
	$query = "SELECT * FROM booking, bookinginfo b WHERE b.roomid = '$roomid' AND b.bookingid=booking.bookingid AND booking.bookingstatus != 'cancelled'";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_array($result)) {

$diff_in_hrs += .5;

}
$value['hours'] = $diff_in_hrs;
$percent = round(($value['hours']/$total)*100,2);
echo "<tr><td>";
echo $value['name']."</td><td>".$percent."%</td></tr>";

}



mysqli_close($conn);

?>
</table>
</div>
</div>
		</div>

<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</body>
</html>
