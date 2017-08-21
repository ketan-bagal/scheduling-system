<?php
	if(isset($_GET["day"]))
	{
	$day = $_GET["day"];
	}
	else {
	$day = "none";
	}
	if(isset($_GET["month"]))
	{
	$month = $_GET["month"];
	}
	else {
	$month = "none";
	}
	if(isset($_GET["year"]))
	{
	$year = $_GET["year"];
	}
	else {
	$year = "none";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<body>

<h1 id="date">
<?php
	echo $day;
?>
y
</h1>





</body>
</html>