<?php
include '../php_script/connectDB.php';
$campusid=$_GET['campusid'];
$selectedtime=$_GET['selectedtime'];
$programmeid=$_GET['programmeid'];
$startdate=$_GET['startdate'];
if($campusid=="Any")
{
	$sql="SELECT * FROM room";
$result = mysqli_query($conn,$sql);
}
else {
$sql="SELECT * FROM building WHERE campusid='".$campusid."'";
$result = mysqli_query($conn,$sql);
}

$row = mysqli_fetch_array($result);
$buildingid = $row['buildingid'];


//change endtime automatically
$sql2="SELECT classduration, duration FROM programme WHERE programmeid='".$programmeid."'";
$result2 = mysqli_query($conn,$sql2);
$row2 = mysqli_fetch_array($result2);
$classduration=$row2['classduration'];
$endtime=$classduration+$selectedtime;
$distime = $selectedtime - 1;
echo "<input type='number' name='endtime' value='".$endtime."' id='endtime' hidden> ";

//change enddate automatically
$weeks=$row2['duration'];
$days=$weeks*7;
$enddate=date('Y-m-d', strtotime($startdate. ' + '.$days.' day'));
echo "<input type='text' name='enddate' value='".$enddate."' id='enddate' hidden>";

echo "<label>Room:</label>";

//$sql4="SELECT room.roomname FROM (SELECT roomname, roomid FROM room WHERE room.buildingid='".$buildingid."') r WHERE r.roomid NOT IN (SELECT roomid FROM cohort WHERE cohort.starttime='".$selectedtime.":00:00')";
//$sql3="SELECT room.roomname FROM room, cohort WHERE room.roomid=cohort.roomid AND room.buildingid='".$buildingid."' AND cohort.starttime!='".$selectedtime.":00:00'";
//$sql3="SELECT roomid FROM room WHERE room.buildingid='".$buildingid."'";
$sql3="SELECT r.roomname FROM (SELECT roomname, roomid FROM room WHERE room.buildingid='".$buildingid."') r WHERE r.roomid NOT IN (SELECT roomid FROM cohort WHERE (cohort.starttime>'".$selectedtime.":00:00' AND cohort.starttime<'".$endtime.":00:00') OR (cohort.starttime<='".$selectedtime.":00:00' AND cohort.endtime>='".$endtime.":00:00') OR (cohort.starttime <'".$selectedtime.":00:00' AND cohort.endtime>'".$selectedtime.":00:00')) ORDER BY r.roomid ASC";
$result3 = mysqli_query($conn,$sql3);
$result4 = mysqli_num_rows($result3);

if ($result4 != null) {
	while($row3 = mysqli_fetch_array($result3)){
		echo "<input type='radio' name='roomid' value='".$row3['roomname']."'>".$row3['roomname'];
	}
}else {
	echo "There is no room available here!";
}

mysqli_close($conn);

?>
