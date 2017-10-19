<?php session_start(); ?>
<?php
if(isset($_GET['submit']))
{
	if($_GET['submit']==1)
	{
	$_SESSION["startdate"] = new DateTime();
	$_SESSION["startdate"] = $_SESSION["startdate"]->format('Y-m-d');
	}
	else
	{
		$_SESSION["startdate"] = $_GET['submit'];
	}
	
	$_SESSION["campusid"] = "Any";
	
	unset($_GET["submit"]);
}

	
	$campusid = $_SESSION["campusid"];
	if(isset($_GET['change']))
	{
		$_SESSION["startdate"] = $_GET['change'];
		$_SESSION["moreDays"]=0;
	}
	$moreDays = 26;
	if(isset($_GET['more']))
	{
		$_SESSION["moreDays"] += 14;
		$moreDays +=$_SESSION["moreDays"];
		unset($_GET['more']);
		
	}





if(isset($_GET["moveMonth"]))
	{
		if($_GET["moveMonth"] == 1)
		{
			$_SESSION["startdate"] = DateTime::createFromFormat('Y-m-d',$_SESSION["startdate"]);
			$_SESSION["startdate"]->modify('-1 month');
			$_SESSION["startdate"] = $_SESSION["startdate"]->format('Y-m-d');
			
		}
		else
		{
			$_SESSION["startdate"] = DateTime::createFromFormat('Y-m-d',$_SESSION["startdate"]);
			$_SESSION["startdate"]->modify('+1 month');
			$_SESSION["startdate"] = $_SESSION["startdate"]->format('Y-m-d');
			
		}
		unset($_GET["moveMonth"]);
	}
	
$checkMon = strtotime($_SESSION["startdate"]);
if(date('l',$checkMon) !== 'Monday')
{
	$_SESSION["startdate"] = date('Y-m-d', strtotime('previous monday', strtotime($_SESSION["startdate"])));
}


	$startdate = DateTime::createFromFormat('Y-m-d',$_SESSION["startdate"]);

	$_SESSION["enddate"] = DateTime::createFromFormat('Y-m-d',$startdate->format('Y-m-d'));
	$_SESSION["enddate"]->modify('+'.$moreDays.' day');
	$enddate = $_SESSION["enddate"];
	
	
	$startdate = $startdate->format('Y-m-d');
	$enddate = $enddate->format('Y-m-d');

	$day = array("Mon","Tue","Wed","Thu","Fri","Sat");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="view recurring"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
	<link href="../css/test.css" rel="stylesheet">
	
</head>
<body>
<div id="page-container">

			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>view Booking</h1>
			<div id="date">
			<h2>
<?php
$td = preg_split("/\-/",$startdate);
$dd = preg_split("/\-/",$enddate);
			echo $td[2]."-".$td[1]."-".$td[0]." ~ ".$dd[2]."-".$dd[1]."-".$dd[0];
?>
</h2>
</div>
<h2 id="cohort"></h2>
<br />
<div class="form1">

<label for='startdate'>Start Week:</label>
<input type="date" id="startdate" name="startdate" value="" onchange="loadNew()" /><br />

<button type="button" onclick="previousMonth()" >Last 4 Weeks</button><br />
<button type="button" onclick="nextMonth()" >Next 4 Weeks</button><br />
</div>

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
<select style='margin=10px;' id='campusid' name='campusid' onchange='search(this.value,0)'>";
echo "<option>Any</option>";
while($row = mysqli_fetch_array($result)) {
	$campusid = $row['campusid'];
	
	
	echo "<option value='".$campusid."'"; if(isset($_SESSION['campusid'])) {if($_SESSION['campusid']==$campusid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
}
echo "</select>";
echo "<br /><br />";
mysqli_close($conn);
?>

<?php
include '../php_script/connectDB.php';
$sql="SELECT * FROM building";
$result = mysqli_query($conn,$sql);
echo "<label for='buildingid'>Building: </label>
<select style='margin=10px;' name='buildingid' id='buildingid' onchange='search(this.value,1)'>";
echo "<option>Select a building</option>";
while($row = mysqli_fetch_array($result)) {
	$buildingid = $row['buildingid'];
	
	echo "<option value='".$buildingid."'"; if(isset($_SESSION['buildingid'])) {if($_SESSION['buildingid']==$buildingid) {echo " selected";}} echo ">" .$row['buildingname']."</option>";
}
echo "</select>";
echo "<br /><br /><br />";
mysqli_close($conn);
?>
<div class="messagepop pop">
		<p><input type="text" value="" name="scroll" id="scroll"/></p>
        <p><input type="button" value="Confirm" id="message_submit"/> or <a class="close" href="/">Cancel</a></p>
</div>
</div><!-- end of form1 -->

<script src="../js/jquery.js"></script>
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

	function search(searchValue,searchKey) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
			if(searchKey==0)
			{
				window.location.href = "./admin_view_recurring_view.php?campusid=" + searchValue;
				 
			}
			if(searchKey==1)
			{
				window.location.href = "./admin_view_recurring_view.php?buildingid=" + searchValue; 
			}
			
    } 
	
	</script>
<?php
	include '../php_script/connectDB.php';
		$count=0;
		$rooms = array();
		if(isset($_SESSION['campusid']) && ($_SESSION['campusid']!="Any"))
		{
			$campusid=$_SESSION['campusid'];
			if(isset($_SESSION['buildingid']))
			{
				$buildingid = $_SESSION['buildingid'];
				$result2 = "SELECT room.*,b.*,campus.* FROM building b,room,campus WHERE campus.campusid='".$campusid."' AND campus.campusid=b.campusid AND b.buildingid='".$buildingid."' AND b.buildingid=room.buildingid";
			}
			else
			{
				$result2 = "SELECT room.*,b.*,campus.* FROM building b,room,campus WHERE campus.campusid='".$campusid."' AND campus.campusid=b.campusid AND b.buildingid=room.buildingid";
			}
		}
		elseif(isset($_GET['buildingid']) && ($_GET['buildingid']!="Select a building"))
		{
			$buildingid=$_GET['buildingid'];
			$result2 = "SELECT room.*,b.buildingname FROM building b,room WHERE b.buildingid='".$buildingid."' AND b.buildingid=room.buildingid";
			
		}
		else
		{
			$result2 = "SELECT room.* FROM room";
		}
		
		if(($runquery2 = $conn->query($result2)) )
		{
			while($row = $runquery2->fetch_assoc())
			{
				$rooms[$row["roomid"]]["name"] = $row["roomname"];
				$rooms[$row["roomid"]]["id"] = $row["roomid"];
			}
		}
		if(!$runquery2)
		{
			  $_SESSION['error'] = "Query error: ".mysqli_error($conn);
		}
		
$result = "SELECT s.*,c.*,p.*,school.name AS schoolname FROM semester s,cohort c,programme p,school WHERE c.cohortid=s.cohortid AND ((s.startdate >='$startdate' AND s.startdate <='$enddate') OR (s.enddate >='$startdate' AND s.enddate <='$enddate') OR (s.startdate <='$startdate' AND s.enddate >= '$enddate')) AND c.programmeid=p.programmeid AND p.schoolid=school.schoolid";
if(($runquery = $conn->query($result)) )
		{
			while($row = $runquery->fetch_assoc())
			{
				if(isset($rooms[$row["roomid"]]["name"]))
				{
				$rooms[$row["roomid"]]["booked"][$count]["roomid"] = $row["roomid"];
				$rooms[$row["roomid"]]["booked"][$count]["classstarttime"] = substr((string)$row["starttime"],0,-3);
				$rooms[$row["roomid"]]["booked"][$count]["classendtime"] = substr((string)$row["endtime"],0,-3);
				$rooms[$row["roomid"]]["booked"][$count]["cohortid"] = $row["cohortid"];
				$rooms[$row["roomid"]]["booked"][$count]["startdate"] = $row["startdate"];
				$rooms[$row["roomid"]]["booked"][$count]["enddate"] = $row["enddate"];
				$rooms[$row["roomid"]]["booked"][$count]["semestername"] = $row["semestername"];
				$rooms[$row["roomid"]]["booked"][$count]["programmename"] = $row["name"];
				$rooms[$row["roomid"]]["booked"][$count]["schoolname"] = $row["schoolname"];
				$count++;
				}
			}
		}
		if(!$runquery)
		{
			  $_SESSION['error'] = "Query error: ".mysqli_error($conn);
		}
		
?>

<script>
  jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", jQuery(window).scrollTop());
	 
    return this;
  }
 
var target;

/*  function deselect(e) {
  $('.pop').slideFadeToggle(function() {
    e.removeClass('selected');
  });    
}
 
 $(function() {
  $('.ttnb').on('click', function() {
    if($(this).hasClass('selected')) {
      deselect($(this));               
    } else {
      $(this).addClass('selected');
      $('.pop').slideFadeToggle();
	  $('.pop').center();
	  $('#scroll').val($(this).attr("data-supid"));
    }
    return false;
  });

  $('.close').on('click', function() {
    deselect($('.ttnb'));
    return false;
  });
}); 

$.fn.slideFadeToggle = function(easing, callback) {
	
  return this.animate({ opacity: 'toggle', height: 'toggle' }, 'fast', easing, callback);
}; */

$(function() {
    // Stick the #nav to the top of the window
    var date = $('#date');
    var navHomeY = date.offset().top;
    var isFixed = false;
    var $w = $(window);
    $w.scroll(function() {
        var scrollTop = $w.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
            date.css({
                position: 'fixed',
                top: 0,
                left: date.offset().left,
                width: date.width()
            });
			date.css("background-color","white");
            isFixed = true;
        }
        else if (!shouldBeFixed && isFixed)
        {
            date.css({
                position: 'static'
            });
            isFixed = false;
        }
    });
});

<?php
$rooms = json_encode($rooms);
echo "var rooms = ".$rooms.";\n";
$startdate = json_encode($startdate);
echo "var startdate = ".$startdate.";\n";
$enddate = json_encode($enddate);
echo "var enddate = ".$enddate.";\n";
$count = json_encode($count);
echo "var count = ".$count.";\n";
?>
var dayname = ["Mon","Tue","Wed","Thu","Fri","Sat"];

function createTable(startdate,enddate) {
	
	var body = document.getElementById("booking");
	var table = document.createElement("table");
	var tb  = document.createElement("tbody");
	var td;
	var tr;
	
	tb.id = "tbody";

	var colNameLen = 2;
	var rowNameLen=2;
	var roomCnt=0;
	
	var arr =[];
	for (var q in rooms) {
		arr[roomCnt] = rooms[q];
		roomCnt++;
	  }
	roomCnt = 0;
	var numOfWeeks = 4;
	var dbTimeList = ["08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00"];
	var convenTimeList = ["08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","1:00","1:30","2:00","2:30","3:00","3:30","4:00","4:30","5:00","5:30","6:00","6:30","7:00","7:30","8:00","8:30","9:00"];
	
	var dayi=0;
	var timei=0;
	
	var dateVal = startdate;
	var timeVal = 0;
	var roomVal = "";
	
	var weekTitle = startdate;
	
	var tooltip;
	
	var dayTemp;
	
	for(var i = 0; i < (convenTimeList.length * arr.length) + colNameLen; i++)
	{
		tr = document.createElement("tr");
		
		for(var j=0; j < (dayname.length * numOfWeeks) + rowNameLen; j++)
		{

			if(i==0)  				//first row
			{
				if(j==0)
				{
					td = document.createElement("td");
					icon = document.createElement("img");
					icon.src="../pic/up.png";
					icon.id = "big";
					icon.setAttribute("onclick","optimizeSize();");
					td.appendChild(icon);
					
				}
				else if(j==1)
				{
					td = document.createElement("td");
					td.appendChild(document.createTextNode("Weeks"));
				}
				else if(j%dayname.length==colNameLen)
				{
					td = document.createElement("td");
					td.appendChild(document.createTextNode(weekTitle)); 
					td.colSpan=dayname.length;
					
					weekTitle = addDays(7,weekTitle);
					
				}
				else
				{
					//merged cells
				}
			
			}
			else if(i==1)			//second row
			{
				td = document.createElement("td");
				
				if(j==0)
				{
					td.appendChild(document.createTextNode("Rooms")); 
				}
				else if(j==1)
				{
					//empty cell
				}
				else
				{
						td.appendChild(document.createTextNode(dayname[dayi])); 
						dayi++;
						if(dayi%dayname.length==0) dayi=0;
				}	
				
			}
			else			//from third row
			{
				
				if(j==0 && i%convenTimeList.length==rowNameLen)		//room list
				{
						td = document.createElement("td");
						td.appendChild(document.createTextNode(arr[roomCnt]["name"])); 
						
						roomVal = arr[roomCnt]["name"];
						
						roomCnt++;
						td.rowSpan=convenTimeList.length;
				}
				else if((j==0 && !(i%convenTimeList.length==rowNameLen)) || (j==1 && (i%convenTimeList.length==rowNameLen)))
				{
					td = document.createElement("td");
					td.appendChild(document.createTextNode(convenTimeList[timei])); 
					timei++;
					
					
				}
				else		//data cells
				{
					if(!(i%convenTimeList.length==rowNameLen) && j==1)
					{
						
					}
					else
					{
						
						td = document.createElement("td");
						
						
						dayTemp = new Date(dateVal);
						
						tooltip = document.createElement("span");
						tooltip.className="tt-content";
						tooltip.innerHTML= "<b>" + dateVal + " "+ dayname[dayTemp.getDay()-1]+" "+convenTimeList[timei-1]+"</b><br />";
						td.className="tt";
						
						//check if it is booked
						if((arr[roomCnt-1]["booked"]))
						{
							
							for(var cohort in arr[roomCnt-1]["booked"])
							{
								//check date
								if(((arr[roomCnt-1]["booked"][cohort]["startdate"]<=dateVal)&&(dateVal<=arr[roomCnt-1]["booked"][cohort]["enddate"])) && ((arr[roomCnt-1]["booked"][cohort]["classstarttime"]<=dbTimeList[timei-1])&&(dbTimeList[timei-1]<arr[roomCnt-1]["booked"][cohort]["classendtime"])))
								{
									td.appendChild(document.createTextNode(arr[roomCnt-1]["booked"][cohort]["cohortid"]));

									tooltip.innerHTML+= arr[roomCnt-1]["booked"][cohort]["cohortid"] + " Sem. " + arr[roomCnt-1]["booked"][cohort]["semestername"] + "<br />" + arr[roomCnt-1]["booked"][cohort]["programmename"] + " " + arr[roomCnt-1]["booked"][cohort]["schoolname"];
									
									td.className+=" ttb";
									//td.style.backgroundColor = "#F3C7DE";
									//.style.color = "#000000";
								}
							}
							
						
						}
						else
						{
							td.className+=" ttnb";
						}
						
						td.appendChild(tooltip);	
						
						dateVal = addDays(1,dateVal);
						if(j%dayname.length==(rowNameLen-1))
						{
							dateVal = addDays(1,dateVal);
						}
						
						
					}
				}
			}
			
			td.style.padding="6px";
			td.style.minWidth="70px";
			td.style.height="50px";
			tr.appendChild(td);
			
			
		}
		tb.appendChild(tr);
		dateVal = startdate;
		if(timei%convenTimeList.length==0) timei=0;
		
	}


table.appendChild(tb);
table.style.marginRight="30px";
body.appendChild(table);
body.style.width="2300px";



}

function clearTables()
{
	var booking = document.getElementById("booking");
	booking.innerHTML = "";
}

function addDays(days,date)
{
	var d = new Date(date);
	d.setDate(d.getDate() + days);
	
	var month = d.getMonth()+1;
	var date = d.getDate();
	if(month.toString().length==1)
	{
		month = "0"+month;
	}
	if(date.toString().length==1)
	{
		date = "0"+date;
	}
	var st = d.getFullYear() + "-" + month + "-" + date;
	return st;
}

function showCheckbox(roomnumber) {

	$('.dis'+roomnumber).each(function(){
		if($(this).css("visibility")=="hidden")
		{
			$(this).css("visibility","visible");
		}
		else
		{
			$(this).css("visibility","hidden");
		}
	});
}
function loadNew() {
	var valu = $('#startdate').val();
	
	window.location.href = './admin_view_recurring_view.php?change='+valu;
}
function loadMore() {
	window.location.href = './admin_view_recurring_view.php?more=1';
}
function clickCollapse(className) {
	$('.collapse'+className).each(function(){
		$(this).css("display","none");
	});
}
function undoCollapse() {
	$("td[style*='display: none']").each(function(){
		$(this).css("display","table-cell");
	});
}
function previousMonth() {
	window.location.href = './admin_view_recurring_view.php?moveMonth=1';
}
function nextMonth() {
	window.location.href = './admin_view_recurring_view.php?moveMonth=2';
}
function optimizeSize() {
	var table = document.getElementById("booking");
	var tds = table.getElementsByTagName("TD");
	var i;
	var icon = document.getElementById("big");
	if(icon)
	{
		for(i = 0; i < tds.length; i++)
		{
			tds[i].style.minWidth="0";
			tds[i].style.height="0";
			tds[i].style.padding="0";
			tds[i].style.fontSize="10px";
		}
		
		icon.id = "small";
	}
	else
	{
		icon = document.getElementById("small");
		for(i = 0; i < tds.length; i++)
		{
			tds[i].style.minWidth="100px";
			tds[i].style.height="50px";
			tds[i].style.padding="8px";
			tds[i].style.fontSize="14px";
		}
		
		icon.id = "big";
	}
}
</script>

<div id="booking">
</div>

<script>

clearTables();
createTable(startdate,enddate);
window.history.pushState('page2', 'view booking', './admin_view_recurring_view.php');
</script>

</div>
</div>
</body>
</html>