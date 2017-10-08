<?php
include '../php_script/connectDB.php';
$cohortid=$_GET['cohortid'];
if($cohortid=="")
{
echo "<span>no course found</span>";
}
else {
	$sql="SELECT * FROM course WHERE programmeid = (SELECT programmeid FROM cohort WHERE cohortid='$cohortid')";
	//$sql = "SELECT programmeid FROM cohort WHERE cohortid='$cohortid'";
	$result = mysqli_query($conn,$sql);

	if(!mysqli_num_rows($result)){
		
		echo "<span>no course found</span>";
		
	}else{
		
		echo"<select name='courseid'>";
		echo "<option value='' hidden selected>Select a course</option>";
		while($row = mysqli_fetch_array($result)) {
			$courseid = $row['courseid'];
			echo "<option value=".$courseid; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row['name']."</option>";
		}
		echo "</select>";
		
		
	}
}
mysqli_close($conn);
?>