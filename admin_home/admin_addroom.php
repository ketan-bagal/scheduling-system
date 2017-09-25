<?php session_start();?>
<?php
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 1){
		header('location:../error_page.php');
	}

?>
<!--bring values into form-->
<?php
$count=0;
	if(isset($_GET['copy']) || isset($_GET['edit']) || isset($_SESSION['errorid']))
	{

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
			$roomid=$_SESSION['errorid'];
			unset($_SESSION['errorid']);
		}
	include '../php_script/connectDB.php';
	$result = "SELECT r.* FROM room r WHERE r.roomid='".$roomid."'";
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
				$disability=$row['disability'];
				$FixedResources=$row['fixedresources'];
			}
		}
		else
		{
			$_SESSION['error']="couldnt bring copied data";
		}
		mysqli_close($conn);
	}
	$data=array();
	if(isset($_SESSION["addingfailid"]))
	{

		$childnum=$_SESSION['childnum'] ;
		for($i = 1; $i <= $childnum;$i++)
				{
					$data["roomid".$i]=$_SESSION['roomid'.$i];
					$data["roomname".$i]=$_SESSION['roomname'.$i];
					$data["capacity".$i]=$_SESSION['capacity'.$i];
					$data["FixedResources".$i]=$_SESSION['FixedResources'.$i];
					unset($_SESSION['roomid'.$i],$_SESSION['roomname'.$i],$_SESSION['capacity'.$i],$_SESSION['FixedResources'.$i]);
				}
		$roomid=$_SESSION["addingfailid"];
		$roomname = $_SESSION['roomname'];
		$capacity = $_SESSION['capacity'];
		$disability = $_SESSION['disability'];
		$FixedResources = $_SESSION['FixedResources'];
		$floornumber = $_SESSION['floornumber'];
		$buildingid = $_SESSION['buildingid'];
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
				<h1>Add Room</h1>

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
<div id="container_form">
<div class="form">
<form id="container" action="./admin_addroom_script.php" method="post">
<fieldset>
<input type="radio" name="roomtype" value="0" onclick="clearAreas()" checked hidden>
<!--<label><input type="radio" name="roomtype" value="1" onclick="askAreas()" <?php //if(isset($_SESSION["addingfailid"])) {echo "checked";}?>>Multi</label>-->
<div id="askAreas">
</div>
<input type="text" name="roomname" value="<?php if(isset($roomname)) echo $roomname;?>" placeholder="Room name">
<script>
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
    //Added by hun
    function changeBuildingOptions(buildingid) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("floornumber").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET","../php_script/getfloorform_script.php?buildingid="+buildingid,true);
        xmlhttp.send();

    }
	function askAreas() {
		var check = document.getElementById("askareas");
		if(check == null)
		{
		var div = document.getElementById("askAreas");


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
			input7.appendChild(option);
		}
		addAreas(2);
		}

	}
	function clearAreas() {
		var div = document.getElementById("child");
		div.innerHTML='';
		var div2 = document.getElementById("askAreas");
		div2.innerHTML='';
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
		inputDiv.className = "resource"+number;
		var num = document.createElement("p");
		num.innerHTML = number;
		num.className = number;
		var input = document.createElement('input');
		var label = document.createElement('label');
		label.innerHTML = "Resource:";
		input.type="text";
		input.name = "resources"+number;
		input.placeholder="If there is any";
		if(data["FixedResources"+number])
		{
		input.value = data["FixedResources"+number];
		}
		inputDiv.appendChild(num);
	inputDiv.appendChild(label);
	inputDiv.appendChild(input);
	resourceDiv.appendChild(inputDiv);
		return resourceDiv;
	}
	function addAreas(areas) {
		var div = document.getElementById("child");
		if(div.innerHTML!="")
		{
			div.innerHTML="";
		}
		for(var i=1;i<=areas;i++)
		{

		var label = document.createElement("label");
		label.innerHTML ="\n Room #"+ i + "\n";
		var label2 = document.createElement("label");
		label2.innerHTML = "room id:";
		var input = document.createElement("input");
		input.type="text";
		input.id="roomid"+i;
		input.name="roomid"+i;
		if(data["roomid"+i])
		{
		input.value = data["roomid"+i];
		}
		var label5 = document.createElement("label");
		label5.innerHTML = "room name:";
		var input4 = document.createElement("input");
		input4.type="text";
		input4.id="roomname"+i;
		input4.name="roomname"+i;
		if(data["roomname"+i])
		{
		input.value = data["roomname"+i];
		}
		var label3 = document.createElement("label");
		label3.innerHTML = "capacity:";
		var input2 = document.createElement("input");
		input2.type="number";
		input2.id="capacity"+i;
		input2.name="capacity"+i;
		if(data["capacity"+i])
		{
		input.value = data["capacity"+i];
		}

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
<?php
include '../php_script/connectDB.php';
$sql="SELECT * FROM campus";
$result = mysqli_query($conn,$sql);
echo "
<select id='campusid' name='campusid' onchange='changeOptions(this.value)'>";
echo "<option value='' hidden selected>Select a campus</option>";
while($row = mysqli_fetch_array($result)) {
	$currentid = $row['campusid'];

	echo "<option value='$currentid'"; if(isset($campusid)) {if($campusid==$currentid) {echo " selected";}} echo ">" .$row['campusname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>

<?php
include '../php_script/connectDB.php';
$sql="SELECT * FROM building";
$result = mysqli_query($conn,$sql);

echo "
<select name='buildingid' id='buildingid'>";
echo "<option value='' hidden selected>Select a building</option>";
while($row = mysqli_fetch_array($result)) {
	$currentbid = $row['buildingid'];
	echo "<option value=".$currentbid; if(isset($buildingid)) {if($buildingid==$currentbid) {echo " selected";}} echo ">" .$row['buildingname']."</option>";
}
echo "</select>";
mysqli_close($conn);
?>
<div id="floornumber">
	<input type="number" name="floornumber" min="0" placeholder="Floor number" value="<?php if(isset($floornumber)) echo $floornumber;?>">
</div>
<input type="number" name="capacity" min="0" placeholder="Capacity" value="<?php if(isset($capacity)) echo $capacity;?>">

<label for='disability'>Disability:</label>
<label><input type="radio" id="dis" name="disability" value="0" onclick="" checked>no</label>
<label><input type="radio" id="nodis" name="disability" value="1" onclick="" >yes</label>

<div class="resources"><div class="resource1"><p class="0"></p>
	<!--<input id="resourceInput1" type="text" placeholder="Resource (If there is any)" name="resources" value="<?php //if(isset($FixedResources)) {echo $FixedResources;} ?>">-->
</div>
</div>

<!--<div id="child">
</div>-->
</fieldset>
<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='Submit'>"; $_SESSION['updatingid']=$roomid;} else {echo "<input type='submit' name='new' value='Submit'>";}
?>

</form>
</div>
</div>
		</div>
		</div>

<script>

<?php
if(isset($_SESSION["addingfailid"]))
	{
		echo "var howManyAreas = ".$_SESSION['childnum'].";\n";
		echo "addAreas(howManyAreas);\n";
		echo "$('#askareas').val(howManyAreas);";
	}
	if(isset($disability))
	{
		echo "$('#dis').prop('checked', false);\n";
		echo "$('#nodis').prop('checked', true);\n";
	}
?>
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
			}else{
				var patt = new RegExp("^[a-z0-9_-]{3,15}$");
				if(!patt.test(roomname)){
					alertify.log("Roomname format is not correct");
					flag=false;
				}

			}
			/*var roomtype = document.forms["container"]["roomtype"].value;
			if (roomtype == null || roomtype == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("room type is required");
				flag=false;
			}*/
			var roomtype = document.getElementsByName('roomtype');
			var roomtype_value="";
			for(var i = 0; i < roomtype.length; i++){
				if(roomtype[i].checked){
					roomtype_value = roomtype[i].value;
				}
			}
			if (roomtype_value == null || roomtype_value == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Room type is required.");
				flag=false;
			}
			var buildingid = document.forms["container"]["buildingid"].value;
			if (buildingid == null || buildingid == "Select a building")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("building is required");
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
<?php
	$data = array();
	unset($_SESSION['roomid'],$_SESSION['childnum'],$_SESSION["addingfailid"]);
?>
<?php include '../php_includes/footer.php';?>
</body>
</html>
