<?php session_start();?>
<?php 
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}
	
?>
<!--bring values into form-->
<?php
$count=0;
$childResourceCount=0;
	if(isset($_GET['copy']) || isset($_GET['edit']) || isset($_SESSION['errorid']))
	{
		$resources = array();
		$comparing = array();
		
		$data=array();
		$count2=0;
		if(isset($_GET['copy']))
		{
		$roomid=$_GET['copy'];
		}
		elseif(isset($_GET['edit']))
		{
		$roomid=$_GET['edit'];
		}
		else
		{
			$_GET['edit']=$_SESSION['errorid'];
			$roomid = $_GET['edit'];
			unset($_SESSION['errorid']);
		}
	include '../php_script/connectDB.php';
	$result = "SELECT r.* FROM room r WHERE r.roomid='".$roomid."'";
	$result2 = "SELECT m.* FROM multiroomchild m WHERE m.roomid='".$roomid."' ORDER BY multiroomchildid";
		if($runquery=mysqli_query($conn,$result))
		{
			while($row = $runquery->fetch_assoc())
			{
				$roomtype=$row['roomtype'];
				$roomid=$row['roomid'];
				$roomname=$row['roomname'];
				$buildingid=$row['buildingid'];
				$floornumber=$row['floornumber'];
				$capacity=$row['capacity'];
				
				$FixedResources= $row['fixedresources'];
			}
		}
		else
		{
			$_SESSION['error']="couldnt bring copied data";
		}
		if($runquery2=mysqli_query($conn,$result2))
		{
			$i2=0;
			while($row2 = $runquery2->fetch_assoc())
			{
				
				$count2++;$i2++;
				
				$data["data".$i2]['multiroomchildid']=$row2['multiroomchildid'];
				$data["data".$i2]['roomname']=$row2['roomname'];
				$data["data".$i2]['capacity']=$row2['capacity'];
				
				$data["data".$i2]['FixedResources']=$row2['fixedresources'];
				
			}
		}
		else
		{
			$_SESSION['error']="couldnt bring copied data from area query";
		}
		mysqli_close($conn);
	}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Add Room"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Calendar</h1>	
			
<div id='error'>
		<?php
				if(isset($_SESSION['error']))
				{	
					print $_SESSION['error'];
					if(isset($_SESSION['lead']))
					{
						print $_SESSION['lead'];
					}
					unset($_SESSION['error']);
					unset($_SESSION['lead']);
				}
				
		?>
</div><!--error--><br />
<script type='text/javascript'>
var alreadyRun = false;
<?php
$js_data = json_encode($data);
echo "var data = ".$js_data.";\n";
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
	
	function askAreas() {
		var div = document.getElementById("askAreas");
		div.innerHTML='';
		var array = ["2","3","4","5"];
		var input7 = document.createElement("select");
		input7.id = "askareas";
		input7.name = "askareas";
		input7.setAttribute("onclick","decideAreas()");
		var label7 = document.createElement("label");
		label7.innerHTML = "How many areas?";
		div.appendChild(label7);
		div.appendChild(input7);
		for(var i=0;i<array.length;i++)
		{
			var option = new Option(array[i],array[i]);
			option.value=array[i];
			input7.appendChild(option);
		}
		addAreas(2);
		
		
	}
	function clearAreas() {
		var div = document.getElementById("child");
		div.innerHTML='';
		div = document.getElementById("askAreas");
		div.innerHTML='';
		
	}
	function decideAreas() {
		var areas;
		if(document.getElementById("askareas") != null)
		{
		var select = document.getElementById("askareas");
		areas = select.options[select.selectedIndex].value;
		
		addAreas(areas);
		
		}
		else
		{
			areas = 0;
		}
		return areas;
	}
	function createResource(number) {
		var resourceDiv = document.createElement("div");
		resourceDiv.className = "resources";
		var inputDiv = document.createElement("div");
		inputDiv.className = "resource1";
		var num = document.createElement("p");
		num.innerHTML = number;
		num.className = number;
		var input = document.createElement('input');
		var label = document.createElement('label');
		label.innerHTML = "Resource:";
		input.type="text";
		input.name = "resources"+number;
		input.placeholder="If there is any";
		if(data["data"+number])
		{
		input.value = data["data"+number]["FixedResources"];
		}
		
		inputDiv.appendChild(num);
	inputDiv.appendChild(label);
	inputDiv.appendChild(input);
	resourceDiv.appendChild(inputDiv);
		return resourceDiv;
	}
	function addAreas(areas) {
		var div = document.getElementById("child");
		div.innerHTML='';
		for(var i=1;i<=areas;i++)
		{
		
		var label = document.createElement("label");
		label.innerHTML ="\n Room #"+ i + "\n";
		var label2 = document.createElement("label");
		label2.innerHTML = "room id:";
		var hidden = document.createElement("input");
		hidden.type="text";
		hidden.id="roomid"+i;
		hidden.name="roomid"+i;
		var input = document.createElement("p");
		if(data["data"+i])
		{
		input.innerHTML=data["data"+i]["multiroomchildid"];
		hidden.value=data["data"+i]["multiroomchildid"];
		}
		var label5 = document.createElement("label");
		label5.innerHTML = "room name:";
		var input4 = document.createElement("input");
		input4.type="text";
		input4.id="roomname"+i;
		input4.name="roomname"+i;
		if(data["data"+i])
		{
		input4.value=data["data"+i]["roomname"];
		}
		var label3 = document.createElement("label");
		label3.innerHTML = "capacity:";
		var input2 = document.createElement("input");
		input2.type="number";
		input2.id="capacity"+i;
		input2.name="capacity"+i;
		if(data["data"+i])
		{
		input2.value=data["data"+i]["capacity"];
		}
		 input2.max=1000;
		input2.min=0;
		
		div.appendChild(label);
		
		div.appendChild(label5);
		div.appendChild(input4);
		div.appendChild(label3);
		div.appendChild(input2);
		
		
		var subdiv = createResource(i);
		div.appendChild(subdiv);
	}
	}
</script>
<div id="container">
<div class="form">
<form id="container" action="./admin_addroom_script.php">
<fieldset>
<label for='roomtype'>Room type:</label>
<label><input type="radio" name="roomtype" value="0" onclick="clearAreas()">Single</label>
<label><input type="radio" name="roomtype" value="1" onclick="askAreas()" checked>Multi</label>
<div id="askAreas">
<label>How many areas?</label>
<select name="askareas" id="askareas" onclick="decideAreas();editingResource();">
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>
</div>


<label for="roomname">Room name:</label>
<input type="text" name="roomname" value="<?php if(isset($roomname)) echo $roomname;?>" placeholder="Room name">

<?php
include '../php_script/connectDB.php';
$sql="SELECT * FROM campus";
$result = mysqli_query($conn,$sql);
echo "<label for='campusid'>Campus: </label>
<select id='campusid' name='campusid' onchange='changeOptions(this.value)'>";
echo "<option>Any</option>";
while($row = mysqli_fetch_array($result)) {
	$currentid = $row['campusid'];
	echo "<option value='".$currentid."'"; if(isset($campusid)) {if($campusid==$currentid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>

<?php
include '../php_script/connectDB.php';
$sql="SELECT * FROM building";
$result = mysqli_query($conn,$sql);
echo "<label for='buildingid'>Building: </label>
<select name='buildingid' id='buildingid'>";
echo "<option>Select a building</option>";
while($row = mysqli_fetch_array($result)) {
	$currentbid = $row['buildingid'];
	echo "<option value=".$currentbid; if(isset($buildingid)) {if($buildingid==$currentbid) {echo " selected";}} echo ">" .$row['buildingname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>

<label for="floornumber">Floor number:</label>
<input type="text" name="floornumber" value="<?php if(isset($floornumber)) echo $floornumber;?>">

<label for="capacity">Capacity:</label>
<input type="number" min="0" max="1000" name="capacity" value="<?php if(isset($capacity)) echo $capacity;?>">


<div class="resources"><div class="resource1"><p class="0">0</p>
	<label>Resource</label>
	<input id="resourceInput1" type="text" placeholder="If there is any" name="resources" value="<?php if(isset($FixedResources)) {echo $FixedResources;} ?>">
</div>
</div>
<div id="child">
<script>
var howManyAreas;
if(!alreadyRun)
{
	howManyAreas = <?php echo $count2; ?>;
addAreas(howManyAreas);
$('#askareas').val(howManyAreas);
alreadyRun=true;
}
</script>
</div>
</fieldset>
<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='submit'>"; $_SESSION['updatingid']=$roomid;} else {echo "<input type='submit' name='new' value='submit'>";}
?>

</form>
</div>
</div>
		</div>
		</div>
		<script>

	$("#container").on('submit', function () 
		{	
		
		var roomid1 =[];var roomname1 = [];	var capacity1 = [];var roomaccesslevel1 = [];
			var flag;
			var d = 5000;
			if(document.getElementById("askareas") != null)
			{
			var select = document.getElementById("askareas");
			var num = select.options[select.selectedIndex].value;
			}
			
			var roomname = document.forms["container"]["roomname"].value;
			if (roomname == null || roomname == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("room name is required");
				flag=false;
			}
			var roomtype = document.forms["container"]["roomtype"].value;
			if (roomtype == null || roomtype == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("room type is required");
				flag=false;
			}
			var buildingid = document.forms["container"]["buildingid"].value;
			if (buildingid == null || buildingid == "Select a building") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("building id is required");
				flag=false;
			}
			var floornumber = document.forms["container"]["floornumber"].value;
			if (floornumber == null || floornumber == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("floornumber is required");
				flag=false;
			}
			var capacity = document.forms["container"]["capacity"].value;
			if (capacity == null || capacity == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("capacity is required");
				flag=false;
			}
			
			if(num)
			{
for(var i=1;i<=num;i++)
			{
			
			roomname1[i] = document.forms["container"]['roomname'+i].value;
			if (roomname1[i] == null || roomname1[i] == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("room name #"+i+" is required");
				flag=false;
			}
			capacity1[i]=document.forms["container"]['capacity'+i].value;
			if (capacity1[i] == null || capacity1[i] == "") 
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("capacity #"+i+" is required");
				flag=false;
			}
			
			}
			
			
			}
			
			
			return flag;
		});
		</script>
		<br><br><br><br><br><br><br><br>
<?php include '../php_includes/footer.php';?>
</body>
</html>