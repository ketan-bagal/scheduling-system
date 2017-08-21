<?php
include '../php_script/connectDB.php';
$programmeid=$_GET['programmeid'];

$querySemesters="SELECT semesters FROM programme WHERE programmeid='".$programmeid."'";
$runSemesters = mysqli_query($conn,$querySemesters);
echo "
		  <tr>
			    <th>Semester</th>
			  	<th>Priority</th>
			  	<th>Courses</th>
			  	<th>Extra</th>
		  </tr>
";

$queryCourses= "SELECT courseid, name FROM course WHERE programmeid = '".$programmeid."'";
$runCourses= mysqli_query($conn,$queryCourses);
$courseList = "";
while($rowCourses = mysqli_fetch_array($runCourses)){
	$courseList .='<option value="'.$rowCourses['courseid'].'">'.$rowCourses['name'].'</option>';
}

while($rowSemesters = mysqli_fetch_array($runSemesters)){

	$semesters = $rowSemesters['semesters'];
	for ($semester=1; $semester <= $semesters ; $semester++) {
		echo '
			<tr class="semester'.$semester.' first">
			    <th rowspan="4">Semester '.$semester.'</th>
			    <td>1</td>
			    <td><select name = "'.$semester.'1" onchange="checkList(this)">
			    '.$courseList."<option value='0'>not listed</option>".'
				</select>
				<div id="'.$semester.'1"></div>
				</td>
			    <th rowspan="4"><input type="button" name="extra" value="add course" onclick="addCourse('.$semester.')"></th>
			</tr>
		 ';
		 for ($i=2; $i <=4 ; $i++) {
		 	echo'	
		 		<tr class="semester'.$semester.'">
				    <td>'.$i.'</td>
				    <td>
					<select name = "'.$semester.$i.'" onchange="checkList(this)">
				    	'.$courseList."<option value='0'>not listed</option>".'
				    </select>
					<div id="'.$semester.$i.'"></div>
					</td>
				</tr>
				';
		 }
		 

	}
	echo "<tr><td><input type='hidden' name='semesters' value='".$semesters."'></td></tr>";
}
mysqli_close($conn);

?>