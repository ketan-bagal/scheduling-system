<?php
include '../php_script/connectDB.php';
$campusid=$_GET['campusid'];
if($campusid=="Any")
{
	$sql="SELECT * FROM room";
$result = mysqli_query($conn,$sql);
}
else {
$sql="SELECT * FROM building WHERE campusid='".$campusid."'";
$result = mysqli_query($conn,$sql);
}
echo "<option value=''>Select a room</option>";
while($row = mysqli_fetch_array($result)){
	$buildingid = $row['buildingid'];
	$sql2="SELECT * FROM room WHERE buildingid='".$buildingid."'";
	$result2 = mysqli_query($conn,$sql2);
while($row2 = mysqli_fetch_array($result2)){
	echo "<option value=".$row2['roomid']; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row2['roomname']."</option>";
}
}
echo "</select>";
mysqli_close($conn);

?>
