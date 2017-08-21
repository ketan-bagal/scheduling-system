<?php
include '../php_script/connectDB.php';
$campusid=$_GET['campusid'];
if($campusid=="Any")
{
	$sql="SELECT * FROM programme";
$result = mysqli_query($conn,$sql);
}
else {
$sql="SELECT * FROM campus_programme WHERE campusid='".$campusid."'";
$result = mysqli_query($conn,$sql);
}

echo "<option>Select a programme</option>";
while($row = mysqli_fetch_array($result)){
	$programmeid = $row['programmeid'];
	$sql2="SELECT * FROM programme WHERE programmeid='".$programmeid."'";
	$result2 = mysqli_query($conn,$sql2);
while($row2 = mysqli_fetch_array($result2)){
	echo "<option value=".$programmeid; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row2['name']."</option>";
}
}

mysqli_close($conn);

?>
