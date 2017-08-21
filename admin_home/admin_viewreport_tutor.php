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
	<?php $title="View Report"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>View Report</h1>	
<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{	
					print $_SESSION['error'];	
					unset($_SESSION['error']);
				}
				
		?>
</div><!--error--><br />
<div class="tables">
<table id='student_resit' class='border'>
			<tr>
			<th width = '220px' nowrap></th>
			<th>Hours</th>
			</tr>
<?php
include '../php_script/connectDB.php';
$tutors = array();
$sql="SELECT * FROM tutor";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)) {
	$tutors[$row['tutorid']]['tutorname'] = $row['firstname']." ".$row['lastname'];
	$tutors[$row['tutorid']]['tutorid'] = $row['tutorid'];
}
foreach($tutors as $value)
{
	$diff_in_hrs=0;
	$tutorid = $value['tutorid'];
	$query = "SELECT * FROM coursebooking WHERE tutorid = '$tutorid'";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_array($result)) {
$date1 = $row['startdate'];
$date2 = $row['enddate']; 
$diff = strtotime($date2) - strtotime($date1);
$diff_in_hrs += $diff/3600;
	
}
$value['hours'] = $diff_in_hrs;

echo "<tr><td>";
echo $value['tutorname']."</td><td>".$value['hours']."</td></tr>";

}



mysqli_close($conn);

?>
</table>
</div>
</div>
		</div>

<br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</body>
</html>