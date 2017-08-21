<?php
include '../php_script/connectDB.php';

$sql="SELECT * FROM courses";
$result = mysqli_query($conn,$sql);

echo "<label for='module'>Module: </label>
<select name='moduleid' onchange='showModule(this.value)'>";
echo "<option>Select a module </option>";
while($row = mysqli_fetch_array($result)) {
	$moduleid = $row['moduleid'];
	echo "<option value=".$moduleid.">" .$row['modulename']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>