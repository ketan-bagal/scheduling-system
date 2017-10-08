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
	<?php $title="Add School"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Setup programme</h1>
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
					<form id="form1" action="./admin_addprogrammestructure_script.php" method="post">
						<fieldset>

								<?php
								include '../php_script/connectDB.php';
								echo "<select id='programmeid' name='programmeid'  onchange='changeOptions(this.value)'>";
								echo "<option value='' hidden selected>Select a programme</option>";
								$queryProgramme = "SELECT * FROM programme";
								$runProg = mysqli_query($conn,$queryProgramme);
								while($rowProg = mysqli_fetch_array($runProg)){
									echo "<option value='".$rowProg['programmeid']."'>".$rowProg['name']."</option>";
								}
								echo "</select>";
								?>

							<table id="tableform" name="tableform" style="width:100%">

							</table>

							<br	/>
							<input type='submit' name='submit' value='Submit'>
						</form>
					</div>
				</div>
			</div>
</div>

<script>
window.onload = function(){
	var id = "<?php
		if(isset($_GET['id'])){
			echo $_GET['id'];
		}
		
	?>";
	var programvalue = document.getElementById("programmeid").value;
	if(programvalue==''){
		var selectele = document.getElementById('programmeid');
		selectItemByValue(selectele, id);
		selectele.onchange();
	}
    
}
function selectItemByValue(elmnt, value){

    for(var i=0; i < elmnt.options.length; i++)
    {
      if(elmnt.options[i].value == value)
        elmnt.selectedIndex = i;
    }
  }
function changeOptions(programmeid) {

            // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                document.getElementById("tableform").innerHTML = xmlhttp1.responseText;
            }
        }

        xmlhttp1.open("GET","../php_script/getprogramstructuretable_script.php?programmeid="+programmeid,true);
        xmlhttp1.send();


    }

	function checkList(obj){
		var valueof = obj.value;
		var x = obj.getAttribute("name");
		if(valueof==0){
        xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                document.getElementById(x).innerHTML = xmlhttp1.responseText;
            }
        }
        xmlhttp1.open("GET","../php_script/getcourseform_script.php?selectnum="+x,true);
        xmlhttp1.send();
		}else{
			document.getElementById(x).innerHTML= "";
		}

	}

	function addCourse(semester){
		var count = 1;
		var semes = semester;
		for(semester;semester>=1;semester--){
			count += document.getElementsByClassName("semester"+semester).length;
		}
		var table = document.getElementById("tableform");
		var row = table.insertRow(count);
		row.className = "semester"+semes+" extracourse";
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);

		var semesfirst = document.getElementsByClassName("semester"+semes+" first")
		var thtag = semesfirst[0].getElementsByTagName("th");
		var num = thtag[0].getAttribute("rowspan");
		var addnum = ++num;
		thtag[0].setAttribute("rowspan",addnum);
		thtag[1].setAttribute("rowspan",addnum);
		var programmeid = document.getElementById("programmeid").value;
		cell1.innerHTML = addnum;

		xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                cell2.innerHTML = xmlhttp1.responseText;
            }
        }

        xmlhttp1.open("GET","../php_script/getprogramstructuretableextra_script.php?programmeid="+programmeid+"&semester="+semes+"&coursenum="+addnum,true);
        xmlhttp1.send();


	}
	$("#form1").on('submit', function ()
		{
			var flag;
			var d = 5000;

			var programmeid = document.forms["form1"]["programmeid"].value;
			if (programmeid == null || programmeid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Programme is required");
				flag=false;
			}
			var semesters = document.forms["form1"]["semesters"].value;
			var semester;
			for(semester = 1 ; semester <= semesters; semester++){
			var numofcourse = document.getElementsByClassName("semester"+semester).length;
			var coursenum;
				for(coursenum=1;coursenum <= numofcourse;coursenum++){

					var course = document.forms["form1"].elements.namedItem(semester.toString()+coursenum.toString()).value;
					if (course == null || course == "")
					{
						d += 500;
						alertify.set({ delay: d });
						alertify.log("course"+coursenum+"within semester"+semester+" is required");
						flag=false;
					}
						if(course == "0"){
							var courseex = document.forms["form1"].elements.namedItem(semester.toString()+coursenum.toString()+"ex").value;
							if (courseex == null || courseex == ""){
								d += 500;
							alertify.set({ delay: d });
							alertify.log("course"+coursenum+"within semester"+semester+" is required");
							flag=false;
							}
						}

				}
			}

			return flag;
		});
		
</script>


<br><br>
<div id = "index_footer">
<?php include '../php_includes/footer.php';?>

</div>
<script src="../js/delete_course.js"></script>
</body>
</html>
