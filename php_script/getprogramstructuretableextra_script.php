<?php
include '../php_script/connectDB.php';
$programmeid=$_GET['programmeid'];
$semester=$_GET['semester'];
$coursenum=$_GET['coursenum'];
$queryCourses= "SELECT courseid, name FROM course WHERE programmeid = '".$programmeid."'";
$runCourses= mysqli_query($conn,$queryCourses);
$courseList = "";
while($rowCourses = mysqli_fetch_array($runCourses)){
	$courseList .='<option value="'.$rowCourses['courseid'].'">'.$rowCourses['name'].'</option>';
}

		 	echo'	
					<select name = "'.$semester.$coursenum.'" onchange="checkList(this)">
				    	'.$courseList."<option value='0'>not listed</option>".'
				    </select>
					<div id="'.$semester.$coursenum.'"></div>
				';
mysqli_close($conn);

?>