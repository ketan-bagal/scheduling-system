<?php
include '../php_script/connectDB.php';
$campusid=$_GET['campusid'];
if($campusid=="Any")
{
	$sql="SELECT * FROM building";
$result = mysqli_query($conn,$sql);
}
else {
$sql="SELECT * FROM building WHERE campusid='".$campusid."'";
$result = mysqli_query($conn,$sql);
}
echo "<option value='' hidden selected>Select a building</option>";
while($row = mysqli_fetch_array($result)) {
	$buildingid = $row['buildingid'];
	echo "<option value=".$buildingid; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row['buildingname']."</option>";
}
mysqli_close($conn);
?>