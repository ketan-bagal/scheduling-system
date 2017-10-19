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
	<?php $title="Edit Programme"; ?>
	<?php $filename= "programme";?>
	<?php $DBtable= "programme";?>
	<?php $pkname= "programmeid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Programme</h1>

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
	$result = "DELETE FROM programme WHERE programmeid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editprogramme.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editprogramme.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<div class="">
	<?php
	if(isset($_GET['schoolid']))
	{
		$_SESSION['schoolid']=$_GET['schoolid'];
	}
	include '../php_script/connectDB.php';
	$result2 = "SELECT * FROM school";
	if ($runquery2 = $conn->query($result2)) {
		echo "<label for='buildingid'>School: </label>
		<select name='schoolid' id='schoolid' onchange=\"filter(this.value,'programme','school')\">";
		echo "<option value='all'>All School</option>";
		while ($row2 = $runquery2->fetch_assoc()) {
			$schoolid=$row2['schoolid'];
			echo "<option value='".$row2['schoolid']."'";if(isset($_SESSION['schoolid'])) {if($_SESSION['schoolid']==$schoolid) {echo " selected";}} echo ">" .$row2['name']."</option>";
		}
		echo "</select>";
	}
	mysqli_close($conn);
	 ?>
</div><br>
<?php
	include '../php_script/connectDB.php';
if (isset($_SESSION['schoolid'])) {
	$result = "SELECT programme.*, school.name AS schoolname FROM programme INNER JOIN school ON programme.schoolid=school.schoolid WHERE programme.schoolid='".$_SESSION['schoolid']."'";
	unset($_SESSION['schoolid']);
}
else {
	$result = "SELECT programme.*, school.name AS schoolname FROM programme INNER JOIN school ON programme.schoolid=school.schoolid";
}

		echo "<table id='student_resit' class='border'>
		<thead>
		<tr>

		<th style=\"width:35%;\">Programme</th>
		<th>School</th>
    <th>Credits</th>
    <th>Duration</th>
    <th>Class Duration</th>
		<th>Semesters</th>
    	<th>Level</th>
		</tr>
		</thead>";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$programmeid = $row['programmeid'];
				$onclick= "window.open('./admin_editcourseprogramme.php?programmeid=".$programmeid."')";
				$did = json_encode($row['programmeid']);
				echo "<tr value='$programmeid' class='data'>";
				//echo "<td><a href='./admin_addprogramme.php?edit=$programmeid'><img src='../pic/edit.png' /></a> <!-- <a href='./admin_addprogramme.php?copy=$programmeid'><img src='../pic/copy.png' /></a>--> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td><a href='#' onclick=".$onclick.">" . $row['name'] ."</a><img  style='display:none; position:relative; left:10%;' onclick='confirmAction (\"$userid\",\"$DBtable\",\"$pkname\");' class = 'button_delete' height='20px' width='20px' src='../pic/delete.png' /></td>";
				echo "<td>" . $row['schoolname'] ."</td>";
		        echo "<td>" . $row['credits'] ."</td>";

		        if ($row['duration'] >= 52) {
		            $duration = $row['duration'];

		            if ($duration % 26 == 0) {
		              $year = ($duration / 26) * 0.5;
		                echo "<td>" . $year ."&nbsp year(s)</td>";
		            }else {

		                echo "<td>" . (int)($duration / 52) ."&nbsp year(s) &nbsp".($duration % 52)."&nbsp week(s)</td>";
		            }
		        }else {
		            echo "<td>" . $row['duration'] ."&nbsp weeks</td>";
		        }
		        echo "<td>" . $row['classDuration'] . "</td>";
				echo "<td>" . $row['semesters'] ."</td>";
				echo "<td>" . $row['level'] ."</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		mysqli_close($conn);
		?>
</div>
</div>
		</div>
<script src="../js/delete_row.js"></script>

<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
