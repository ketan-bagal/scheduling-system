

<?php
include '../php_script/connectDB.php';
$programmeid=$_GET['programmeid'];
$sql="SELECT duration FROM programme WHERE programmeid='".$programmeid."'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
	$duration = $row['duration'];
}

echo $duration;
mysqli_close($conn);
?>