<?php session_start(); ?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Edit Courseprogramme"; ?>
	<?php $filename= "programmestructure";?>
	<?php $DBtable= "programme_course";?>
	<?php $pkname= "semester";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Courseprogramme</h1>

				<div id='error'>
						<?php
								if(isset($_SESSION['error']))
								{
									print $_SESSION['error'];
									unset($_SESSION['error']);
								}

						?>
				</div><!--error--><br />
				<?php include '../php_includes/add.php'; ?>
				<div class="tables">
					<div class="">
						<?php
									include '../php_script/connectDB.php';
									echo "<select id='programmeid' name='programmeid'  onchange=\"filter(this.value,'courseprogramme','programme')\">";
									echo "<option hidden>Select programme</option>";
									$queryProgramme = "SELECT * FROM programme";
									$runProg = mysqli_query($conn,$queryProgramme);
									while($rowProg = mysqli_fetch_array($runProg)){
										$programmeid=$rowProg['programmeid'];
										echo "<option value='".$rowProg['programmeid']."'";if(isset($_GET['programmeid'])) {if($_GET['programmeid']==$programmeid) {echo " selected";}} echo ">".$rowProg['name']."</option>";
									}
						?>
					</select>
					</div>
					<br>
					<?php
				include '../php_script/connectDB.php';
				if (isset($_GET['programmeid'])) {
					$programmeid=$_GET['programmeid'];
					unset($_GET['programmeid']);
					$sql="SELECT * FROM programme_course WHERE programmeid = '$programmeid'";
					$runquery=mysqli_query($conn,$sql);
					$result=mysqli_fetch_array($runquery);
					if (!empty($result)) {
					echo "<table id='student_resit' name='tableform' style='width:100%'>

							  <tr>
								    <th style='width:20%'>Semester</th>
								  	<th style='width:50%'>Courses</th>
							  </tr>
					";
				}else {
					echo "<h4>No semester and course for this programme!</h4>";
				}
				$querySemester= "SELECT `semester`, count(*) as 'count' FROM `programme_course` GROUP BY programme_course.semester order by `semester` ASC";
				$runSemester= mysqli_query($conn,$querySemester);
				while ($rowSemester = mysqli_fetch_array($runSemester)) {
					echo "<tr class='data' value='".$rowSemester['semester']."'>
										<td rowspan=".($rowSemester['count']+1)." > Semester ".$rowSemester['semester']."</td>
										</tr>";
										$queryCourses= "SELECT course.name, programme_course.pcid FROM course, programme_course WHERE course.courseid = programme_course.courseid and programme_course.semester= '".$rowSemester['semester']."' ORDER BY programme_course.priority ASC ";
										$runCourses= mysqli_query($conn,$queryCourses);
										while ($rowCourses = mysqli_fetch_array($runCourses)) {
											echo"	<tr class='data_two' value='".$rowCourses['pcid']."'>
																<td >".$rowCourses['name']."</td>
																</tr>	";
										}

				}

					// $queryCourses= "SELECT programme_course.pcid, course.programmeid, course.name, programme_course.semester, sub.count FROM course, programme_course INNER JOIN (SELECT semester, count(semester) AS count FROM course, programme_course WHERE course.courseid = programme_course.courseid AND course.programmeid='".$programmeid."' GROUP BY programme_course.semester) sub ON sub.semester = programme_course.semester WHERE course.courseid = programme_course.courseid AND course.programmeid='".$programmeid."' ORDER BY programme_course.semester, programme_course.priority";
					// $runCourses= mysqli_query($conn,$queryCourses);
					//
					// $semester = 1;
					// while($rowCourses = mysqli_fetch_array($runCourses)){
					// $pcid=$rowCourses['pcid'];
					//
					// 	if ($semester == $rowCourses['semester']) {
					//
					// 		echo "<tr class='data' value='$semester'>
					// 			    <td rowspan=".($rowCourses['count']+1)." >Semester ".$rowCourses['semester']."</td>
					// 					</tr>
					// 					<tr class='data_two' value='$pcid'><td>".$rowCourses['name']."</td>
					// 					</tr>
					// 		 ";
					// 		 $semester++;
					// 	}else{
					//
					// 		echo"	<tr class='data_two' value='$pcid'>
					// 			    <td >".$rowCourses['name']."</td>
					// 					</tr>
					// 		";
					// 	}
					//
					// }
				}
					echo "</table>";
					mysqli_close($conn);

					?>
				</div>
			</div>
		</div>
<script>


$('tr.data_two').each(function() {
	var id = $(this).attr('value');
	var table = document.getElementById('current_table').value;
  var pkname = "pcid";
	$(this).append('<a href=javascript:confirmAction("'+id+'","'+table+'","'+pkname+'")><button class="btn_delete_two" >delete</button></a>');
});
$('tr.data_two').mouseover(function() {
	$(this).find('.btn_delete_two').css('display', 'inline');
}).mouseout(function() {

	$(this).find('.btn_delete_two').css('display', 'none');
});


</script>
<script src="../js/delete_record.js"></script>
<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
