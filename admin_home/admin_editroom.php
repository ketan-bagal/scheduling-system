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
	<?php $title="Edit Room"; ?>
	<?php $filename= "room";?>
	<?php $DBtable= "room";?>
	<?php $pkname= "roomid";?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
	<div id="tables_refresh">
<div id="page-container">

			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Edit Room</h1>

<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}

		?>
</div><!--error--><br />

<div id="search">
<?php
include '../php_script/connectDB.php';
	if(isset($_GET['deletingid']))
	{
	$deletingid=$_GET['deletingid'];
	unset($_GET['deletingid']);
	 $query = "SELECT COUNT(*) as cnt FROM bookinginfo WHERE roomid= '".$deletingid."'";
$runquery = mysqli_query($conn, ($query));
$row = mysqli_fetch_array($runquery);
$cnt = $row['cnt'];

if($cnt >= 1)
{
	$_SESSION['error'] = "There is a adhoc booking made for this room. Delete the booking first";
	header('location: ./admin_editroom.php');
	exit();
 }
 	 $query = "SELECT COUNT(*) as cnt FROM coursebooking WHERE roomid= '".$deletingid."'";
$runquery = mysqli_query($conn, ($query));
$row = mysqli_fetch_array($runquery);
$cnt = $row['cnt'];

if($cnt >= 1)
{
	$_SESSION['error'] = "There is a recurring booking made for this room. Delete the booking first";
	header('location: ./admin_editroom.php');
	exit();
 }
	$result = "SELECT roomtype FROM room WHERE roomid='".$deletingid."'";
	if($runquery=mysqli_query($conn,$result))
			{
				while($row = mysqli_fetch_array($runquery))
				{
					$roomtype = $row['roomtype'];

				}
				$result = "DELETE FROM room WHERE roomid='".$deletingid."'";
				if($roomtype==1)
				{
					$result2 = "DELETE FROM multiroomchild WHERE roomid='".$deletingid."'";


	if($runquery=mysqli_query($conn,$result))
			{
				if($runquery=mysqli_query($conn,$result2))
				{
					$_SESSION['error'] = "deleted successfully";
					header('location: ./admin_editroom.php');
					exit();
				}
				if(!$runquery)
				{
			$_SESSION['error'] = "multiroom areas not deleted ";
			header('location: ./admin_editroom.php');
			exit();
				}
			}
			else
			{
				$_SESSION['error'] = "query wrong";
			header('location: ./admin_editroom.php');
			exit();
			}
				}
				else
				{
					if($runquery=mysqli_query($conn,$result))
					{
						$_SESSION['error'] = "deleted successfully";
					header('location: ./admin_editroom.php');
					exit();
				}
				if(!$runquery)
				{
			$_SESSION['error'] = "not deleted ";
			header('location: ./admin_editroom.php');
			exit();
				}
				}
	}
	else
			{
				$_SESSION['error'] = "selecting query wrong";
			header('location: ./admin_editroom.php');
			exit();
			}
	}
		mysqli_close($conn);
?>
</div>
<div class="form1">
<?php
if(isset($_GET['campusid']))
{
	$_SESSION['campusid']=$_GET['campusid'];
	$currentcampusid = $_SESSION['campusid'];
	unset($_SESSION['buildingid']);
}
if(isset($_GET['buildingid']))
{
	$_SESSION['buildingid']=$_GET['buildingid'];
}
include '../php_script/connectDB.php';
$sql="SELECT * FROM campus";
$result = mysqli_query($conn,$sql);

echo "<label for='campusid'>Campus: </label>
<select id='campusid' name='campusid' onchange='search(this.value,0)'>";
echo "<option >Any</option>";
while($row = mysqli_fetch_array($result)) {
	$campusid = $row['campusid'];
	echo "<option value='".$campusid."'"; if(isset($_SESSION['campusid'])) {if($_SESSION['campusid']==$campusid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
}
echo "</select>";

mysqli_close($conn);
?>
<?php
include '../php_script/connectDB.php';
if (isset($_SESSION['campusid']) && $_SESSION['campusid'] != "Any") {
	$sql="SELECT * FROM building WHERE campusid='".$_SESSION['campusid']."'";
}else {
	$sql="SELECT * FROM building";
}
$result = mysqli_query($conn,$sql);
echo "<br /><br /><label for='buildingid'>Building: </label>
<select name='buildingid' id='buildingid' onchange='search(this.value,1)'>";
echo "<option hidden>Select a building</option>";
while($row = mysqli_fetch_array($result)) {
	$buildingid = $row['buildingid'];
	echo "<option value='".$buildingid."'"; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row['buildingname']."</option>";
}
echo "</select><br />";
mysqli_close($conn);
?>

<!-- <label>Capacity (More than)</label>
<input type="text" id="capacity" onchange="filterCapacity(this.value)" /> -->

</div>
<br><br>
<script>

<?php
if(isset($_GET['campusid']))
{
	$jsonid = json_encode($_GET['campusid']);
	echo "var campusid = ".$jsonid.";\n";
}
else
{
	echo "var campusid=null;\n";
}
?>
function changeOptions(campusid) {
            // code for IE7+, Firefox, Chrome, Opera, Safari

        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("buildingid").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET","../php_script/getbuildingform_script.php?campusid="+campusid,true);
        xmlhttp.send();
    }
		if(campusid!=null)
		{

			changeOptions(campusid);
		}
	function filterCapacity(value) {

		window.location.href = "./admin_editroom.php?capacity=" + value;
	}
	function search(searchValue,searchKey) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
			if(searchKey==0)
			{
				window.location.href = "./admin_editroom.php?campusid=" + searchValue;
			}
			if(searchKey==1)
			{
				window.location.href = "./admin_editroom.php?buildingid=" + searchValue;
			}

    }
	</script>
	<?php include '../php_includes/add.php'; ?>
<div class="tables">
<?php
	include '../php_script/connectDB.php';
		$count=0;
		if(isset($_SESSION['campusid']) && ($_SESSION['campusid']!="Any"))
		{
			$campusid=$_SESSION['campusid'];
			if(isset($_SESSION['buildingid']))
			{
				$buildingid = $_SESSION['buildingid'];
				unset($_SESSION['buildingid']);
			if(isset($_GET['capacity']))
			{
				$capacity = $_GET['capacity'];
				$result2 = "SELECT room.*,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.campusid='".$campusid."' AND b.buildingid='".$buildingid."' AND room.capacity>'$capacity'";
			}
			else
			{

			$result2 = "SELECT room.*,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.campusid='".$campusid."' AND b.buildingid='".$buildingid."'";
			}
			}
			else
			{
				$result2 = "SELECT room.*,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.campusid='".$campusid."'";
			}
		}
		elseif(isset($_GET['buildingid']) && ($_GET['buildingid']!="Select a building"))
		{
			$buildingid=$_GET['buildingid'];
			$result2 = "SELECT room.*,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.buildingid='".$buildingid."'";

		}
		elseif(isset($_GET['capacity']))
		{
			$capacity = $_GET['capacity'];
			$result2 = "SELECT room.*,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND room.capacity>'$capacity'";
		}
		else
		{
			$result2 = "SELECT room.*,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid";
		}
		if(($runquery2 = $conn->query($result2)) )
		{
			echo "<table id='student_resit' class='border'>
			<thead>
			<tr>

			<th>Room</th>
			<th>Building</th>
			<th>Campus</th>
			<th>Capacity</th>
			<th>Floornumber</th>
			<!--<th>Fixed resources</th>-->
			</tr>
			</thead>";
			$data=array();
			while($row = $runquery2->fetch_assoc())
			{
				$data[$row["roomid"]]["FixedResources"] = $row["fixedresources"];
				$data[$row["roomid"]]["roomname"] = $row["roomname"];
				$data[$row["roomid"]]["roomid"] = $row["roomid"];
				$data[$row["roomid"]]["roomtype"] = $row["roomtype"];
				$data[$row["roomid"]]["buildingname"] = $row["buildingname"];
				$data[$row["roomid"]]["buildingid"] = $row["buildingid"];
				$data[$row["roomid"]]["campusname"] = $row["campusname"];
				$data[$row["roomid"]]["campusid"] = $row["campusid"];
				$data[$row["roomid"]]["capacity"] = $row["capacity"];
				$data[$row["roomid"]]["disability"] = $row["disability"];
				$data[$row["roomid"]]["floornumber"] = $row["floornumber"];
				// if($row["roomtype"]==1)
				// {
				// 	$childQuery="SELECT * from multiroomchild WHERE roomid='".$row['roomid']."' ORDER BY multiroomchildid";
				// 	if($runChildQuery = $conn->query($childQuery))
				// 	{
				// 		while($row2 = $runChildQuery->fetch_assoc())
				// 		{
				//
				// 			$data[$row["roomid"]]["child"][$row2["multiroomchildid"]]['roomname']=$row2["roomname"];
				// 			$data[$row["roomid"]]["child"][$row2["multiroomchildid"]]['capacity']=$row2["capacity"];
				// 			$data[$row["roomid"]]["child"][$row2["multiroomchildid"]]['FixedResources']=$row2['fixedresources'];
				//
				// 		}
				// 	}
				//
				// 	if(!$runChildQuery)
				// 	{
				// 		 $_SESSION['error'] = "child room Query error: ".mysqli_error($conn);
				// 		 header('location: ./admin_editroom.php');
				// 		 exit();
				//
				// 	}
				// }

			}

			function sortingRoom($a,$b) {
				return $a["roomid"] > $b["roomid"];
			}
			usort($data, "sortingRoom");

			foreach($data as $value)
			{

				$roomid = $value["roomid"];
				//escape character for string to be used in javascript function
				$did = json_encode($roomid);
				$dis="";
				if($value['disability']==1)
						{
							$dis = "yes";
						}
						else
						{
							$dis = "no";
						}
				echo "<tr value='".$value['roomid']."' class='data'>";


				/*if($value['roomtype']==1)
				{
					echo "<td><a href='./admin_editmulti.php?edit=$roomid'><img src='../pic/edit.png' /></a> <a href='./admin_editmulti.php?copy=$roomid'><img src='../pic/copy.png' /></a> <a href='javascript:confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
				}
				else
				{
				echo "<td><a href='./admin_addroom.php?edit=$roomid'><img src='../pic/edit.png' /></a> <a href='./admin_addroom.php?copy=$roomid'><img src='../pic/copy.png' /></a> <a onclick='confirmAction($did)'><img src='../pic/delete.png' /></a></td>";
			}*/
				echo "<td >" . $value["roomname"] ."\n";
				if(isset($value["child"]))
					{

					foreach($value["child"] as $subkey => $subvalue)
					{


					echo "- ",$subvalue["roomname"],"<br>\n";
					}
					}

				echo "<img  onclick='confirmAction (\"$roomid\",\"$DBtable\",\"$pkname\");' class = 'button_delete' height='20px' width='20px' src='../pic/delete.png' /></td>";
				echo "<td >" . $value['buildingname']."</td>";
				echo "<td >" . $value['campusname']."</td>";
				echo "<td>" . $value['capacity'] ."\n";
				if(isset($value["child"]))
					{
					foreach($value["child"] as $subkey => $subvalue)
					{
					echo $subvalue["capacity"],"<br>\n";
					}
					}
					echo "</td>";
				echo "<td >" . $value['floornumber'] ."</td>";
				// echo "<td>";
				//
				// if(isset($value["FixedResources"]))
				// {
				// 	echo $value["FixedResources"]."<br>\n";
				//
				// }
				//
				//
				// if(isset($value['child']))
				// {
				//
				// foreach($value['child'] as $subkey =>$subvalue)
				// {
				// 	if(isset($subvalue["FixedResources"]))
				// 	{
				// 	echo $subvalue["FixedResources"],"<br>\n";
				// 	}
				// }
				//
				// }
				//
				// echo "</td></tr>";
echo "</tr>";

			}
		}
		if(!$runquery2)
		{
			  $_SESSION['error'] = "Query error: ".mysqli_error($conn);
			  header('location: ./admin_editroom.php');
						 exit();

		}
		echo "</table>";
		mysqli_close($conn);
		?>

</div>
</div>

</div>

<script src="../js/delete_row.js"></script>

<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
