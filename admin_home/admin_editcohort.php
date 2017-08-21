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
	<?php $title="Edit Cohort"; ?>
	<?php $filename= "cohort";?>
	<?php $DBtable= "cohort";?>
	<?php $pkname= "cohortid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">


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
<?php
include '../php_script/connectDB.php';
	if(isset($_GET['deletingid']))
	{
	$deletingid=$_GET['deletingid'];
	unset($_GET['deletingid']);
	$result = "DELETE FROM cohort WHERE cohortid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editcohort.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editcohort.php');
			exit();
			}
	}
		mysqli_close($conn);
?>


<?php
date_default_timezone_set('NZ');
$year = date("Y");

echo "<form id='' action='".$_SERVER['PHP_SELF']."' method='post'>

<label for='currentyear'>Current Year:</label>
<input type='number' name='year' value='".$year."'>
<input type='submit' name='submit' value='View'>

</form>";



if (isset($_POST['year'])) {
$_SESSION['year'] = $_POST['year'];
$year=$_POST['year'];
}

echo "<div class=''>
	<form class='' action='downloadCSV.php' method='post'>
		<input type='hidden' name='csvyear' value='".$year."'>
		<input type='submit' name='' value='download'>
	</form>
</div>";






echo "<h1><center>".$year ."&nbspSCHEDULE </h1></center>";


	include '../php_script/connectDB.php';

  $result = "SELECT c.campusid, c.campusname FROM building b, room r, campus c, semester, cohort WHERE cohort.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND cohort.cohortid=semester.cohortid AND semester.startdate BETWEEN '".$year."-01-01' AND '".$year."-12-31' GROUP BY campusid";

  if ($runquery = $conn->query($result))
  {
    while($row = $runquery->fetch_assoc())
    {
      echo "<center><h1>".$row['campusname']."</h1></center>";
      $result2 = "SELECT campus_programme.*, programme.name AS programmename, programme.semesters FROM campus_programme, programme, cohort WHERE  cohort.programmeid=programme.programmeid AND cohort.programmeid=campus_programme.programmeid AND campus_programme.campusid='".$row['campusid']."' GROUP BY programmeid";
      $runquery2 = $conn->query($result2);

      while($row2 = $runquery2->fetch_assoc())
      {
		    echo  "<center><h3>".$row2['programmename']."</h3></center>";

				$result3 = "SELECT a.*, r.roomname, semester.startdate, semester.semestername FROM building b, room r, campus c, cohort a, semester WHERE a.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND semester.cohortid=a.cohortid AND a.programmeid='".$row2['programmeid']."' GROUP BY cohortid";
				//$result3 = "SELECT a.*,r.roomname, semester.startdate AS cohortstartdate, sub.enddate AS cohortenddate FROM building b, room r, campus c, cohort a, semester INNER JOIN (SELECT semester.enddate,semester.cohortid FROM semester, cohort WHERE cohort.cohortid = semester.cohortid AND semester.semestername='".$row2['semesters']."') sub ON sub.cohortid = semester.cohortid WHERE a.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND semester.cohortid=a.cohortid AND semester.semestername='1' AND a.programmeid='".$row2['programmeid']."'";
      //  $result3 = "SELECT cohort.*,r.roomname, semester.startdate AS cohortstartdate, semester.enddate AS cohortenddate FROM building b, room r, campus c, cohort, semester WHERE cohort.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND semester.cohortid=cohort.cohortid AND semester.semestername='semester1' OR semester.semestername='semester'".$row2['semesters']."' AND cohort.programmeid='".$row2['programmeid']."'";
			//$result3 = "SELECT cohort.*,r.roomname, semester.startdate AS cohortstartdate, semester.enddate AS cohortenddate FROM building b, room r, campus c, cohort, semester WHERE cohort.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND semester.cohortid=cohort.cohortid AND semester.semestername='semester1' OR semester.semestername='semester".$row2['semesters']."' AND cohort.programmeid='".$row2['programmeid']."'";
        echo "<table id='student_resit' class='border'>
    		<thead><tr>

        <th>Cohort</th>";

				for ($i=0; $i < $row2['semesters'] ; $i++) {
				echo "
    		<th>Start</th>
        <th>End</th>
        <th>Time</th>
    		<th>Room</th>";
				}

    		echo "</tr></thead>
				<tr>
			
				<td></td>";

				for ($i=0; $i < $row2['semesters'] ; $i++) {
					echo "<td colspan='4' >Semester".($i+1)."</td>";
				}

    		echo "</tr>";
        $runquery3 = $conn->query($result3);
        	while($row3 = $runquery3->fetch_assoc())
        	{
						if ($year== date('Y', strtotime($row3['startdate']))) {
          		$cohortid = $row3['cohortid'];
          		$did = json_encode($row3['cohortid']);
          		echo "<tr value='$cohortid' class='data'>";
          		//echo "<td><a href='./admin_addcohort.php?edit=$cohortid'><img src='../pic/edit.png' /></a> <!--<a href='./admin_addcohort.php?copy=$cohortid'><img src='../pic/copy.png' /></a>--> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
          		echo "<td>" . $row3['cohortid'] ."</td>";



							$result4 = "SELECT startdate AS cohortstartdate, enddate AS cohortenddate FROM semester WHERE cohortid = '".$row3['cohortid']."' ORDER BY semestername ASC";
							$runquery4 = $conn->query($result4);
			        	while($row4 = $runquery4->fetch_assoc())
								{
									echo "<td>" . date('d-m-Y', strtotime($row4['cohortstartdate'])) ."</td>";
          				echo "<td>" . date('d-m-Y', strtotime($row4['cohortenddate'])) ."</td>";

          				echo "<td>" . date('h a', strtotime($row3['starttime']))."&nbsp - &nbsp".date('h a', strtotime($row3['endtime']))."</td>";
          				echo "<td>" . $row3['roomname'] ."</td>";
									}

          		echo "</tr>";

						}
        	}
        	echo "</table>";
      	}
		}
  }







  /*
	$result = "SELECT cohort.*,r.roomname,c.campusname FROM building b, room r, campus c, cohort WHERE cohort.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid";
		echo "<table id='student_resit' class='border'>
		<thead><tr>
		<th></th>
		<th>cohort</th>
		<th>Room</th>

		</tr>
		</thead>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$cohortid = $row['cohortid'];
				$did = json_encode($row['cohortid']);
				echo "<tr>";
				echo "<td><a href='./admin_addcohort.php?edit=$cohortid'><img src='../pic/edit.png' /></a> <!--<a href='./admin_addcohort.php?copy=$cohortid'><img src='../pic/copy.png' /></a>--> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td>" . $row['cohortid'] ."</td>";
				echo "<td>" . $row['roomname'] ."</td>";

				echo "</tr>";
			}
		}
		echo "</table>";
    */
		mysqli_close($conn);
		?>
</div>
</div>
		</div>
<script src="../js/delete_record.js"></script>
<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
