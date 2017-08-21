<?php
include './connectDB.php';
$programmeid=$_GET['programmeid'];

echo "
		  <tr>
			    <th>Semester</th>
			  	<th>Courses</th>
		  </tr>
";

$queryCourses= "SELECT programme_course.pcid, course.programmeid, course.name, programme_course.semester, sub.count FROM course, programme_course INNER JOIN (SELECT semester, count(semester) AS count FROM course, programme_course WHERE course.courseid = programme_course.courseid AND course.programmeid='".$programmeid."' GROUP BY programme_course.semester) sub ON sub.semester = programme_course.semester WHERE course.courseid = programme_course.courseid AND course.programmeid='".$programmeid."' ORDER BY programme_course.semester, programme_course.priority";
$runCourses= mysqli_query($conn,$queryCourses);

$semester = 1;
while($rowCourses = mysqli_fetch_array($runCourses)){
$pcid=$rowCourses['pcid'];

	if ($semester == $rowCourses['semester']) {

		echo "<tr value='$pcid' class='data'>
			    <th rowspan=".($rowCourses['count']+1).">Semester ".$rowCourses['semester']."</th>
					</tr>
					<tr><td>".$rowCourses['name']."</td></tr>
		 ";
		 $semester++;
	}else{

		echo"	<tr>
			    <td>".$rowCourses['name']."</td>
					</tr>
		";
	}

}
mysqli_close($conn);

?>
