<?php
$moduleId=$_GET['moduleId'];

include '../php_script/connectDB.php';
$sql="SELECT * FROM assessment WHERE moduleid = '".$moduleId."'";
$result = mysqli_query($conn,$sql);

echo "<label >Assessment: </label>
<select name='assessmentid' onchange='showType(this.value)'>";
echo "<option>Select an assessment </option>";
while($row = mysqli_fetch_array($result)) {
	$assessmentid = $row['assessmentid'];
	echo "<option value=".$assessmentid.">" . $row['title']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>