<?php
include '../php_script/connectDB.php';
$selectNum=$_GET['selectnum'];

$sql="SELECT * FROM course";
$result = mysqli_query($conn,$sql);
echo"<select name='".$selectNum."ex'>";
echo "<option value='' >Select a course</option>";
while($row = mysqli_fetch_array($result)){
	$coursename = $row['name'];
	$courseid = $row['courseid'];
	echo "<option value=".$courseid; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row['name']."</option>";
}
echo "</select>";
mysqli_close($conn);

?>