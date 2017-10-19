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
								echo "<option  value='' hidden selected>Select a campus</option>";
								
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
								<select name='programmeid' id='programmeid' style='display:none;' onchange='setSemester(this.value);'>";
								echo "<option value='' hidden selected>Select a programme</option>";
								while($row = mysqli_fetch_array($result)) {
									$currentbid = $row['programmeid'];
									echo "<option value=".$currentbid; if(isset($schoolid)) {if($schoolid==$currentbid) {echo " selected";}} echo ">" .$row['name']."</option>";
								}
								echo "</select>";
								mysqli_close($conn);
								?>
								 <label style="display:none;"> Programme duration(weeks):</label>
								<input id="programmedura" name="duration" value="0" style="display:none;" disabled> 

								<label for="campusname" >Start Date:</label>
								<input type="date" name="startdate" id="submit_startdate" onchange="calculateProjectedEnddate(this.value);fetchRoomTime(this.value);" readonly>
								<label for="campusname" style="display:none;">End Date:</label>
								<input type="date" name="enddate" onchange="calculdura();" style="display:none;" id="submit_enddate">
								<label for="campusname" style="display:none;">Duration(weeks):</label>
								<input id="duration" name="duration" value="0" style="display:none;" disabled>
								<label for="campusname" style="display:none;">Start 	Time:</label>
								<input type="time" name="starttime" id="submit_starttime" style="display:none;" readonly>
								<label for="campusname" style="display:none;">End Time:</label>
								<input type="time" name="endtime" id="submit_endtime" style="display:none;" readonly>

								<div id="semesters">
								</div>
								<button type="button" name="button" id="view_available_slot" onclick="document.getElementById('myPopup').style.display='initial';myFunction();" hidden>view available slot</button>
								 <?php
								 include '../php_script/connectDB.php';
								$sql="SELECT * FROM room";
								$result = mysqli_query($conn,$sql);
								echo "
								<select style='display:none;' name='roomid' id='roomid'>";
								echo "<option hidden selected>Select a room</option>";
								echo "</select>";
								mysqli_close($conn); 
								?> 
							</fieldset>
							<input type='submit' name='submit' value='Submit'>

						</form>

					</div>
				</div>
				
				<div id="room_summary_button" style="position:fixed; bottom:400px; right:0;overflow:auto;margin:15% auto;width:10%; padding:10px;z-index:8;">
				<span onclick="document.getElementById('room_summary').style.display='block'">open</span>
				</div>
				<div id="room_summary" style="position:fixed; bottom:400px; right:0; width:30%; height:45%; overflow:auto; z-index:9;";>
				<div id="room_summary_content" style="background-color: #fefefe; margin:15% auto; padding:10px; border: 1px solid #888; width:80%;">
				<span style="float:right; z-index:8;" onclick="document.getElementById('room_summary').style.display='none'">close</span>
					<h3 id="projectedEnddate">Projected Enddate &emsp;&emsp;</h3>
					<h3 id="ee"></h3>
				</div>
				</div>
				
				<div id="cohort_summary_button" style="position:fixed; bottom:10px; right:0;overflow:auto;margin:15% auto;width:10%; padding:10px;z-index:8;">
				<span onclick="document.getElementById('cohort_summary').style.display='block'">open</span>
				</div>
				<div id="cohort_summary" style="position:fixed; bottom:10px; right:0; width:30%; height:45%; overflow:auto; z-index:9;";>
				<div id="cohort_summary_content" style="background-color: #fefefe; margin:15% auto; padding:10px; border: 1px solid #888; width:80%;">
				<span style="float:right; z-index:8;" onclick="document.getElementById('cohort_summary').style.display='none'">close</span>
					<h3 id="summary_s_1">Sem 1 &emsp;&emsp;</h3>
					<h3 id="summary_b_1" class="oddSumm" style="">Break   </h3>
					<h3 id="summary_s_2" >Sem 2 &emsp;&emsp;</h3>
					<h3 id="summary_b_2" class="oddSumm">Break   </h3>
					<h3 id="summary_s_3">Sem 3 &emsp;&emsp;</h3>
					<h3 id="summary_b_3" class="oddSumm">Break   </h3>
					<h3 id="summary_s_4">Sem 4 &emsp;&emsp;</h3>
					<h3 id="summary_b_4" class="oddSumm">Break   </h3>
					<h3>_____________</h3>
					<h3 id="summary_total">Total &emsp;&emsp;</h3>
					<h3 id="summary_prog">Prog. &emsp;&emsp;</h3>
				</div>
				</div>
				
			</div>
</div>

<div id="myPopup" class="modal">
	<div class="modal-content animate">
  	<div class="titlecontainer">
    	<span onclick="document.getElementById('myPopup').style.display='none'; document.getElementById('error_guide').innerHTML='';" class="close" title="Close Modal">&times;</span>
    	<h4>available room and time</h4>
    	<hr>
  	</div>

		<div class="container">
			<span id="error_guide" style="color:red"></span><br>
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
	try {
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
		$('#start_semester1').attr('readonly', 'true');
		var semesters = document.getElementById('get_semesters').value;
		var end_semester = document.getElementById('submit_enddate').value;
		$('#end_semester' + semesters).val(end_semester);
		$('#end_semester' + semesters).attr('readonly', 'true');
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
	var val = document.getElementById('campusid').value;
	if (val == '') {
		document.getElementById('error_guide').innerHTML="Please select campus and programme first, then try again!";
	}else {
		document.getElementById('myPopup').style.display="none";
	}
	} catch (err) {

			document.getElementById('error_guide').innerHTML="Please select programme first, then try again!";
	}

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


function myFunction() {
	var startdate = document.getElementById('submit_startdate').value;
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
	if(programmeid!="Select a programme")
	{
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
				document.getElementById("summary_prog").innerHTML = "Prog. &emsp;&emsp;" + xmlhttp2.responseText;
            }
        }
        xmlhttp2.open("GET","../php_script/checkTime.php?programmeid="+programmeid,true);
        xmlhttp2.send();
		
		var startdate = document.getElementById("submit_startdate");
		startdate.readOnly = false;
	}
	else
	{
		var startdate = document.getElementById("submit_startdate");
		startdate.readOnly = true;
	}
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
				document.getElementById("programmeid").style.display = "inline";
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
    //evt.currentTarget.className += " active";
	//document.getElementById("test123").innerHTML = cityName;
	}

	function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

	function calculateSemesterEndDate(weeks,number) {
		var start_semester = document.getElementById("start_semester"+number);
		var end_semester = document.getElementById("end_semester"+number);
		var enddate = new Date(start_semester.value);
		enddate.setDate(enddate.getDate()+(weeks*7));
		enddate = formatDate(enddate);
		end_semester.value = enddate;
		
		
		setSem(weeks,number);
	}
	
	function calculateSemesterStartDate(weeks, number) {
		var start_semester = document.getElementById("start_semester"+(number+1));
		var end_semester = document.getElementById("end_semester"+number);
		if(start_semester)
		{
			var startdate = new Date(end_semester.value);
			startdate.setDate(startdate.getDate()+(weeks*7));
			startdate = formatDate(startdate);
			start_semester.value = startdate;
		}
		
		setBreak(weeks,number);
	}
	
function setSem(weeks,number)
{
	document.getElementById("summary_s_"+number).innerHTML = "Sem "+number+"&emsp;&emsp;"+weeks;
	caculateSummaryTotal();
}
function setBreak(weeks,number)
{
	document.getElementById("summary_b_"+number).innerHTML = "Break &emsp;&emsp;"+weeks;
	caculateSummaryTotal();
}

function caculateSummaryTotal()
{
	var total = document.getElementById("summary_total");
	var inputs = document.getElementsByClassName("summaryInputs");
	var num = 0;
	for(var i=0; i<=inputs.length; i++)
	{
		if(inputs[i] && inputs[i].value)
		{
			num += parseInt(inputs[i].value);
		}
	}
	
	total.innerHTML = "Total &emsp;&emsp;"+num;
}

function calculateProjectedEnddate(startdate) {
	var def_startdate = document.getElementById('submit_startdate').value;
		$('#start_semester1').val(def_startdate);
		$('#start_semester1').attr('readonly', 'true');
	document.getElementById('view_available_slot').style.display="inline";
	var programmeDur = document.getElementById("programmedura").value;
	var sd = new Date(startdate);
	var newDate = new Date(sd.setDate(sd.getDate()+(programmeDur*7)));
	var formatted = newDate.getUTCFullYear() + '-' + padNumber(newDate.getUTCMonth() + 1) + '-' + padNumber(newDate.getUTCDate());
	
	 var pe = document.getElementById("projectedEnddate");
	 pe.innerHTML = "Projected Enddate &emsp;&emsp;"+formatted;
	 pe.value = formatted;
}
	
function padNumber(number) {
                var string  = '' + number;
                string      = string.length < 2 ? '0' + string : string;
                return string;
            }
			
function fetchRoomTime(startdate) {
	var e = document.getElementById("ee");
	var campus = document.getElementById("campusid").value;
	var enddate = document.getElementById("projectedEnddate").value;
	var programme = document.getElementById("programmeid").value;
	//e.innerHTML=campus+ " " + startdate + " " + enddate+ " " + programme;
	
	 var xml = "programmeid="+programme+"&startdate="+startdate+"&enddate="+enddate+"&campusid="+campus;
 	xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var rooms = JSON.parse(xmlhttp.responseText); 
			 	var parent = document.getElementById("room_summary_content");
				var child;
				
				var cohortRooms = parent.childNodes;
				if(cohortRooms)
				{
					for(var j = cohortRooms.length-1; j>=0; j--)
					{
						if((cohortRooms[j].className)&& (cohortRooms[j].className=="cohortRooms"))
						{
							cohortRooms[j].parentNode.removeChild(cohortRooms[j]);
						}
					}
				}
				for(var i in rooms)
				{
					child = document.createElement("h4");
					 for(var j in rooms[i])
					{
						child.innerHTML+=rooms[i][j]+" ";
					} 
					//child.innerHTML = rooms[i]["name"] + " " + rooms[i]["19:00"];
					//child.innerHTML = rooms[i]["name"] + " "+ rooms[i]["08:00"]+" " +rooms[i]["09:00"]+" " +rooms[i]["10:00"]+" " +rooms[i]["11:00"]+" " +rooms[i]["12:00"]+" " +rooms[i]["13:00"]+" " +rooms[i]["14:00"]+" " +rooms[i]["15:00"]+" " +rooms[i]["16:00"]+" " +rooms[i]["17:00"]+" " +rooms[i]["18:00"]+" " +rooms[i]["19:00"]+" " +rooms[i]["20:00"]+" " +rooms[i]["21:00"];
					child.className = "cohortRooms";
					parent.appendChild(child); 
			 	}

            }
        }
        xmlhttp.open("GET","../php_script/fetchRoomTime_script.php?"+xml,true);
        xmlhttp.send();  
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
