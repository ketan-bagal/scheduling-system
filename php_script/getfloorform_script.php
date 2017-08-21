<?php
include '../php_script/connectDB.php';
$buildingid=$_GET['buildingid'];

$sql="SELECT * FROM building WHERE buildingid='".$buildingid."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
	$floors = $row['floors'];
	echo "<input type='number' name='floornumber' min='0' max='".$floors."' placeholder='Floor number' value=''>";
}
mysqli_close($conn);
?>