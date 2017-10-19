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
	<?php $title="Edit Campusprogramme"; ?>
	<?php $filename= "campusprogramme";?>
	<?php $DBtable= "campus_programme";?>
	<?php $pkname= "cpid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Campus <img src='../pic/link.png' alt='link' style='width:20px;height:20px;'> Prog.	</h1>

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
	$result = "DELETE FROM campus_programme WHERE cpid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
			$_SESSION['error'] = "deleted successfully";
			header('location: ./admin_editcampusprogramme.php');
			exit();
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editcampusprogramme.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
<?php
	include '../php_script/connectDB.php';
		$result = "SELECT campus.campusname, campus.campusid, count(*) as 'count' FROM campus_programme, campus WHERE campus_programme.campusid=campus.campusid GROUP BY campus_programme.campusid";
	//$result2 = "SELECT campus_programme.cpid, programme.name AS programmename, campus.campusname FROM campus_programme INNER JOIN programme ON campus_programme.programmeid=programme.programmeid INNER JOIN campus ON campus_programme.campusid=campus.campusid";
		echo "<table id='student_resit' name='tableform' style='width:100%'>
		
		<tr>
			<th style='width:30%'>Campus</th>
			<th style='width:70%'>Programme</th>
		</tr>
		";
		if ($runquery = $conn->query($result))
		{
			while($row = $runquery->fetch_assoc())
			{
				
				echo "<tr value='".$row['campusid']."' class='data'>";
				//echo "<td><a href='./admin_addcampusprogramme.php?edit=$cpid'><img src='../pic/edit.png' /></a> <!--<a href='./admin_addcampusprogramme.php?copy=$cpid'><img src='../pic/copy.png' /></a>--> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				echo "<td style='padding:7px' rowspan=".($row['count']+1).">" . $row['campusname'] ."</td>";
				echo "</tr>";
				$result2 = "SELECT campus_programme.cpid, programme.name AS programmename FROM campus_programme, programme WHERE campus_programme.campusid ='".$row['campusid']."' AND campus_programme.programmeid=programme.programmeid";
				$runquery2 = $conn->query($result2);
				while($row2 = $runquery2->fetch_assoc())
				{
					$cpid = $row2['cpid'];
					$did = json_encode($row2['cpid']);
					echo"	<tr  value='".$row2['programmename']."'>";
					echo "<td style='padding:7px' class='data_two'  value='".$cpid."'>" . $row2['programmename'] ."</td>";
					echo "</tr>";
				}
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
<script>
	$('tr .data_two').each(function() {
	var id = $(this).attr('value');
	var table = document.getElementById('current_table').value;
  var pkname = "cpid";
	$(this).append('<a style=\'width:auto; position:relative; left:10%;\' href=javascript:confirmAction("'+id+'","'+table+'","'+pkname+'")><button class="btn_delete_two" >delete</button></a>');
});
$('tr .data_two').mouseover(function() {
	$(this).find('.btn_delete_two').css('display', 'inline');
}).mouseout(function() {

	$(this).find('.btn_delete_two').css('display', 'none');
});
</script>
</body>
</html>
