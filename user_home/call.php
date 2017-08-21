<?php session_start(); ?>
<?php
	if(isset($_GET["day"]))
	{
	$_SESSION['day'] = $_GET["day"];
	}
	if(isset($_GET["month"]))
	{
	$_SESSION['month'] = $_GET["month"];
	}
	
	if(isset($_GET["year"]))
	{
	$_SESSION['year'] = $_GET["year"];
	}
	$day=$_SESSION['day'];
	$month =$_SESSION['month'];
	if(!isset($month[1]))
	{
		$month[1] = $month[0];
		$month[0] = "0";
	}
	if(!isset($day[1]))
	{
		$day[1] = $day[0];
		$day[0] = "0";
	}
	$date = $_SESSION['year']."-".$month."-".$day;
	$tempDat = $day."-".$month."-".$_SESSION['year'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Edit Room"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">

			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Booking</h1>	
			<h2 id="date">
<?php
	echo $tempDat;
?>
</h2>
<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{	
					print $_SESSION['error'];	
					unset($_SESSION['error']);
				}
				
		?>
</div><!--error--><br />
<div class="form1">
<?php
if(isset($_GET['campusid']))
{
	$_SESSION['campusid']=$_GET['campusid'];
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
echo "<option>Any</option>";
while($row = mysqli_fetch_array($result)) {
	$campusid = $row['campusid'];
	
	echo "<option value='".$campusid."'"; if(isset($_SESSION['campusid'])) {if($_SESSION['campusid']==$campusid) {echo " selected";}} echo ">" .$row['campusname']."(".$campusid.")</option>";
}
echo "</select>";
mysqli_close($conn);
?>
<div class = "margin_left" />
<?php
include '../php_script/connectDB.php';
$sql="SELECT * FROM building";
$result = mysqli_query($conn,$sql);
echo "<label for='buildingid'>Building: </label>
<select name='buildingid' id='buildingid' onchange='search(this.value,1)'>";
echo "<option>Select a building</option>";
while($row = mysqli_fetch_array($result)) {
	$buildingid = $row['buildingid'];
	
	echo "<option value='".$buildingid."'"; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row['buildingname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>

<div class = "margin_left" >
<label>Capacity (More than)</label>
<input type="text" id="capacity" onchange="filterCapacity(this.value)" />
</div>
</div>


<div id="time_table" class = "border">
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
var form_allowed_to_submit = false;
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
		
		window.location.href = "./call.php?capacity=" + value;
	}
	function search(searchValue,searchKey) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
			if(searchKey==0)
			{
				window.location.href = "./call.php?campusid=" + searchValue;
				 
			}
			if(searchKey==1)
			{
				window.location.href = "./call.php?buildingid=" + searchValue; 
			}
			
    } 
	
	</script>
<?php
	include '../php_script/connectDB.php';
		$count=0;
		$rooms = array();
		$bookings = array();
		if(isset($_SESSION['campusid']) && ($_SESSION['campusid']!="Any"))
		{
			$campusid=$_SESSION['campusid'];
			if(isset($_SESSION['buildingid']))
			{
				$buildingid = $_SESSION['buildingid'];
			if(isset($_GET['capacity']))
			{
				$capacity = $_GET['capacity'];
				$result2 = "SELECT room.roomname,room.roomtype,room.roomid,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.campusid='".$campusid."' AND b.buildingid='".$buildingid."' AND room.capacity>'$capacity'";
			}
			else
			{
			
			$result2 = "SELECT room.roomname,room.roomtype,room.roomid,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.campusid='".$campusid."' AND b.buildingid='".$buildingid."'";
			}
			}
			else
			{
				$result2 = "SELECT room.roomname,room.roomtype,room.roomid,b.buildingname,campus.* FROM building b, room,campus WHERE b.buildingid=room.buildingid AND b.campusid=campus.campusid AND b.campusid='".$campusid."'";
			}
		}
		elseif(isset($_GET['buildingid']) && ($_GET['buildingid']!="Select a building"))
		{
			$buildingid=$_GET['buildingid'];
			$result2 = "SELECT room.roomname,room.roomtype,room.roomid,b.buildingname FROM building b, room WHERE b.buildingid=room.buildingid AND b.buildingid='".$buildingid."'";
			
		}
		elseif(isset($_GET['capacity']))
		{
			$capacity = $_GET['capacity'];
			$result2 = "SELECT room.roomname,room.roomtype,room.roomid FROM room WHERE room.capacity>'$capacity'";
		}
		else
		{
			$result2 = "SELECT room.roomname,room.roomtype,room.roomid FROM room";
		}
		if(($runquery2 = $conn->query($result2)) )
		{
			while($row = $runquery2->fetch_assoc())
			{
				if($row["roomtype"]==1)
				{
					$childQuery = "SELECT m.roomname,m.multiroomchildid FROM multiroomchild m WHERE m.roomid='".$row["roomid"]."'";
					if(($childrunquery = $conn->query($childQuery)) )
					{
					while($row2 = $childrunquery->fetch_assoc())
					{
						$rooms[$row2["multiroomchildid"]]["name"] = $row2["roomname"];
						$rooms[$row2["multiroomchildid"]]["id"] = $row2["multiroomchildid"];
						$rooms[$row2["multiroomchildid"]]["type"] = $row["roomtype"];
					}
					}
					if(!$childrunquery)
					{
						 $_SESSION['error'] = "Query error: ".mysqli_error($conn);
					}
				}
				else
				{
				$rooms[$row["roomid"]]["name"] = $row["roomname"];
				$rooms[$row["roomid"]]["id"] = $row["roomid"];
				}
				
			}
		}
		if(!$runquery2)
		{
			  $_SESSION['error'] = "Query error: ".mysqli_error($conn);
		}
$result = "SELECT booking.*,b.roomid,b.time FROM booking, bookinginfo b WHERE booking.date='$date' AND b.bookingid = booking.bookingid";	
if(($runquery = $conn->query($result)) )
		{
			while($row = $runquery->fetch_assoc())
			{
				$count++;
				$rooms[$row["roomid"]]["time"][$row["time"]] = $row["bookingstatus"];
			}
		}
		if(!$runquery)
		{
			  $_SESSION['error'] = "Query error: ".mysqli_error($conn);
		}
		
				$result = "SELECT c.* FROM coursebooking c WHERE c.startdate<='$date' AND c.enddate>='$date'";	
if(($runquery = $conn->query($result)) )
		{
			while($row = $runquery->fetch_assoc())
			{
			if(isset($rooms[$row["roomid"]]["name"]))
				{
				
				$rooms[$row["roomid"]]["time"][$row["classstarttime"]] = "confirmed";
				$time = strtotime($row["classstarttime"]);
				$time = date("H:i", strtotime('+30 minutes',$time));
				while(strtotime($row["classendtime"]) >strtotime($time))
				{
				$count++;
				$rooms[$row["roomid"]]["time"][$time] = "confirmed";
				
				$time = date("H:i", strtotime('+30 minutes',strtotime($time)));
				
				}
				
				
				}
			}
		}
		if(!$runquery)
		{
			  $_SESSION['error'] = "Query error: ".mysqli_error($conn);
		}

		
?>

<script>
<?php
$rooms = json_encode($rooms);
echo "var rooms = ".$rooms.";\n";
?>

function createTable(roomname,roomid,bookedTime,rt) {
	var body = document.getElementById("booking");
	var table = document.createElement("table");
	var tb  = document.createElement("tbody");
	var time = ["08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30"];
	 var arrayCount =0;
	 var arrayCount2 =0;
	 var rid = roomid;
	 var booked = bookedTime;
	 var cnt =0;
	 
	 for (var i = 0; i < 6; i++) {
	var tr = document.createElement("tr");
		for (var j = 0; j < 10; j++) {
			cnt = 0;
		if(i != 0 && j == 0)
		{
			
		}
		else
		{
			if((i == 4 && j == 9) || (i == 5 && j == 9))
			{
				
			}
			else
			{
			var td =  document.createElement("td");
			if(i == 0 && j == 0) 
			{
				td.setAttribute('rowSpan','6');
				td.appendChild(document.createTextNode(roomname));
				if(rt==1)
				{
				td.appendChild(document.createTextNode(" (multiroom area)"));
				}
			}
			if(i%2 == 0 && j != 0)
			{
				j == 1  ? td.appendChild(document.createTextNode('Time')) : td.appendChild(document.createTextNode(time[arrayCount])) && arrayCount++;
			}
			if(i%2 == 1 && j != 0)
			{
				if(j == 1)
				{
					td.appendChild(document.createTextNode('Select'));
				}
				else
				{
					if(booked)
					{
						for(var temp in booked)
						{
							if(temp == time[arrayCount2])
							{
								cnt++;
								if(booked[time[arrayCount2]]=="confirmed")
								{
									td.appendChild(document.createTextNode('C'));
								}
								else
								{
									td.appendChild(document.createTextNode('P'));
								}
							}
						}
						if(cnt==0)
						{
							var input = document.createElement("input");
							input.type = "checkbox";
							input.name = "time[]";
							input.value = time[arrayCount2]+"-"+rid;
							td.appendChild(input);
						}
						
					}
					else
					{
						
						var input = document.createElement("input");
					input.type = "checkbox";
					input.name = "time[]";
					input.value = time[arrayCount2]+"-"+rid;
					td.appendChild(input);
					}
					arrayCount2++;
				}
			}
			tr.appendChild(td);
			}
		}
	}
	tb.appendChild(tr);
}
table.appendChild(tb);
body.appendChild(table);
}

function clearTables()
{
	var booking = document.getElementById("booking");
	booking.innerHTML = "";
}
function createRoomInput(roomid)
{
	var body = document.getElementById("booking");
	var input = document.createElement("input");
	input.type = "text";
	input.value = roomid;
	input.name  = "roomid";
	body.appendChild(table);
}

</script>
<form id="container" onsubmit='' action="./call_script.php">
<div id="booking">
</div>
<input type="submit" name="submit" value="submit" />
</form>
<script>
clearTables();
var len = rooms.length;
 for (var i in rooms) {
	if(rooms[i]["type"])
	{
	 createTable(rooms[i]["name"],rooms[i]["id"],rooms[i]["time"],1);
	}
	else
	{
		createTable(rooms[i]["name"],rooms[i]["id"],rooms[i]["time"],0);
	}
 }
 

$("#container").submit(function(event){
    event.preventDefault(); // cancel submit
	var form = $('#container');
var formAction = form.attr('action');
var result = formAction + '?' + form.serialize();
  var z = prompt("Please provide reason for booking.","Meeting");
  if(z===null || z=="")
  {
	  return;
  }
  result = result + '&reason='+z;
  window.location.href = result;
});
</script>
</div>
</div>
</div>
</body>
</html>