<?php session_start();?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Add Cohort"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Add Cohort</h1>
				<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{
					print $_SESSION['error'];
					unset($_SESSION['error']);
				}

		?>
</div><!--error--><br />
				<div id="container">
					<div class="form">
						<form id="form1" action="./admin_addcohort_script.php" method="post" onsubmit="return validateTime();">
							<fieldset>
								<input type="text" name="cohortid" placeholder = "Cohort">
								<?php
								include '../php_script/connectDB.php';
								$sql="SELECT * FROM campus";
								$result = mysqli_query($conn,$sql);
								echo "<select id='campusid' name='campusid'  onchange='changeOptions(this.value)'>";
								echo "<option hidden selected>Select a campus</option>";
								while($row = mysqli_fetch_array($result)) {
									$currentid = $row['campusid'];
									echo "<option value='$currentid'"; if(isset($campusid)) {if($campusid==$currentid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
								}
								echo "</select>";
								mysqli_close($conn);
								?>
								<?php
								include '../php_script/connectDB.php';
								$sql="SELECT * FROM programme";
								$result = mysqli_query($conn,$sql);
								echo "
								<select name='programmeid' id='programmeid' onchange='setSemester(this.value)'>";
								echo "<option value='' hidden selected>Select a programme</option>";
								while($row = mysqli_fetch_array($result)) {
									$currentbid = $row['programmeid'];
									echo "<option value=".$currentbid; if(isset($schoolid)) {if($schoolid==$currentbid) {echo " selected";}} echo ">" .$row['name']."</option>";
								}
								echo "</select>";
								mysqli_close($conn);
								?>
								<label> Programme duration(weeks):</label>
								<input id="programmedura" name="duration" value="0" disabled>

								<label for="campusname" >Start Date:</label>
								<input type="date" name="startdate" id="submit_startdate" onchange="myFunction(this.value)">
								<button type="button" name="button" id="view_available_slot" onclick="document.getElementById('myPopup').style.display='initial'" hidden>view available slot</button>
								<label for="campusname" >End Date:</label>
								<input type="date" name="enddate" onchange="calculdura();" id="submit_enddate">
								<label for="campusname" >Duration(weeks):</label>
								<input id="duration" name="duration" value="0" disabled>
								<label for="campusname" >Start 	Time:</label>
								<input type="time" name="starttime" id="submit_starttime">
								<label for="campusname" >End Time:</label>
								<input type="time" name="endtime" id="submit_endtime">

								<div id="semesters">
								</div>
								<?php
								include '../php_script/connectDB.php';
								$sql="SELECT * FROM room";
								$result = mysqli_query($conn,$sql);
								echo "
								<select name='roomid' id='roomid'>";
								echo "<option hidden selected>Select a room</option>";
								echo "</select>";
								mysqli_close($conn);
								?>
							</fieldset>
							<input type='submit' name='submit' value='submit'>

						</form>

					</div>
				</div>
			</div>
</div>

<div id="myPopup" class="modal">
	<div class="modal-content animate">
  	<div class="titlecontainer">
    	<span onclick="document.getElementById('myPopup').style.display='none'" class="close" title="Close Modal">&times;</span>
    	<h4>available room and time</h4>
    	<hr>
  	</div>

		<div class="container">
			<div id="timecontainer"></div>
			<div id="roomcontainer"></div>
		</div>

		<div class="btcontainer">
  		<button type="submit" onclick="transfer()">Submit</button>
		</div>
	</div>
</div>

<script>

function transfer() {
	var enddate = document.getElementById('enddate').value;
	var starttime = $("input[name='starttime']:checked").val();
	var endtime = document.getElementById('endtime').value;
	var programmeid = document.getElementById('programmeid').value;
	var index = $("input[name='roomid']:checked").val();

document.getElementById('view_available_slot').style.display="inline";
//change enddate
	$('#submit_enddate').val(enddate);

	var startdate =new Date(document.getElementById("submit_enddate").value);
	var enddate =new Date(document.getElementById("submit_startdate").value);
	var timeDiff = Math.abs(startdate.getTime() - enddate.getTime());
	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24*7));
	document.getElementById("duration").value = diffDays;
	//change default of semesters Date

	var def_startdate = document.getElementById('submit_startdate').value;
	$('#start_semester1').val(def_startdate);
	var semesters = document.getElementById('get_semesters').value;
	var end_semester = document.getElementById('submit_enddate').value;
	$('#end_semester' + semesters).val(end_semester);
	//change starttime
	if (starttime >= 10) {
		document.getElementById('submit_starttime').value = starttime+":00";
	}else {
		document.getElementById('submit_starttime').value = "0"+starttime+":00";
	}

//change endtime
	if (endtime >= 10) {
		document.getElementById('submit_endtime').value = endtime+":00";
	}else {
		document.getElementById('submit_endtime').value = "0"+endttime+":00";
	}

//change room in select drop down box
$('[name=roomid] option').filter(function() {
	return ($(this).text() == index);
}).prop('selected', true);

//close popup
	document.getElementById('myPopup').style.display="none";
}


function choiceroom(selectedtime) {
		var campusid = document.getElementById('campusid').value;
		var programmeid = document.getElementById('programmeid').value;
		var startdate = document.getElementById('submit_startdate').value;

		xmlhttp1 = new XMLHttpRequest();
		xmlhttp1.onreadystatechange = function() {
				if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
						document.getElementById("roomcontainer").innerHTML = xmlhttp1.responseText;
				}
		}

		xmlhttp1.open("GET","../php_script/getroomandtime_script.php?campusid="+campusid+"&startdate="+startdate+"&programmeid="+programmeid+"&selectedtime="+selectedtime,true);
		xmlhttp1.send();

}


function myFunction(startdate) {
	var campusid = document.getElementById('campusid').value;
	var programmeid = document.getElementById('programmeid').value;

	var popup = document.getElementById("myPopup");
	popup.style.display="inline";

	xmlhttp1 = new XMLHttpRequest();
	xmlhttp1.onreadystatechange = function() {
			if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
					document.getElementById("timecontainer").innerHTML = xmlhttp1.responseText;
			}
	}

	xmlhttp1.open("GET","../php_script/gettimetable_script.php",true);
	xmlhttp1.send();

	xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function() {
			if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
					document.getElementById("roomcontainer").innerHTML = xmlhttp2.responseText;
			}
	}

	xmlhttp2.open("GET","../php_script/getroomandtime_script.php?campusid="+campusid+"&startdate="+startdate+"&programmeid="+programmeid+"&selectedtime="+9,true);
	xmlhttp2.send();

}

// Get the modal
var modal = document.getElementById('myPopup');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function setSemester(programmeid){
	    xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("semesters").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../php_script/getsemesterform_script.php?programmeid="+programmeid,true);
        xmlhttp.send();

		xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function() {
            if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
                document.getElementById("programmedura").value = xmlhttp2.responseText;
            }
        }
        xmlhttp2.open("GET","../php_script/checkTime.php?programmeid="+programmeid,true);
        xmlhttp2.send();
}
function validateTime(){
		var dura = document.getElementById("duration").value;
		var programmeid = document.getElementById("programmeid").value;
		var d = 5000;
		var flag = true;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("GET","../php_script/checkTime.php?programmeid="+programmeid,false);
				xmlhttp.send();
				var c = parseInt(dura,10);
				var e = parseInt(xmlhttp.responseText,10);
				if(c!=e){
					d += 500;
					alertify.set({ delay: d });
					alertify.log("Corhort duration not right!");
					flag = false;
				}


		var cohortid = document.forms["form1"]["cohortid"].value;
			if (cohortid == null || cohortid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Cohortid is required");
				flag=false;
			}
		var semesters = document.forms["form1"]["semesters"].value;
		var i;
		for(i = 1;i<=semesters;i++){
			var semesterSD=document.forms["form1"]["semesterS"+i].value;
			var semesterED=document.forms["form1"]["semesterE"+i].value;
			if (semesterSD == null || semesterSD == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("semester"+i+"start time is required");
				flag=false;
			}
			if (semesterED == null || semesterED == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("semester"+i+"end time is required");
				flag=false;
			}
		}
		
		return flag;
	}

function changeOptions(campusid) {
        xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                document.getElementById("programmeid").innerHTML = xmlhttp1.responseText;
            }
        }
        xmlhttp1.open("GET","../php_script/getprogrammeform_script.php?campusid="+campusid,true);
        xmlhttp1.send();
		xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function() {
            if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
                document.getElementById("roomid").innerHTML = xmlhttp2.responseText;
            }
        }
        xmlhttp2.open("GET","../php_script/getroomform_script.php?campusid="+campusid,true);
        xmlhttp2.send();
    }
	function calculdura(){
		var startdate =new Date(document.getElementById("submit_enddate").value);
		var enddate =new Date(document.getElementById("submit_startdate").value);
		var timeDiff = Math.abs(startdate.getTime() - enddate.getTime());
		var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24*7));
		document.getElementById("duration").value = diffDays;

		var semesters = document.getElementById('get_semesters').value;
		var end_semester = document.getElementById('submit_enddate').value;
		$('#end_semester' + semesters).val(end_semester);
	}
	function openCity(cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
	document.getElementById("test123").innerHTML = cityName;
	}





</script>

<?php
	unset($_SESSION['campusname'],$_SESSION['campusid'],$_SESSION['address']);
?>
<br><br>
<div id = "index_footer">
<?php include '../php_includes/footer.php';?>
</div>
</body>
</html>
