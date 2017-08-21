<?php session_start(); ?>
<?php 
	if(!isset($_SESSION['usertype'])|| $_SESSION['usertype']!= 0){
		header('location:../error_page.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>		
		<?php $title="User home";include '../php_includes/head_elements.php'; ?>
		 <link href='http://fonts.googleapis.com/css?family=Economica' rel='stylesheet' type='text/css'>
		  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
		<!-- Respomsive slider -->
		<link href="../css/responsive-calendar.css" rel="stylesheet">
	</head>
	<body>
		<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">

				<div class="container">
				<!-- Responsive calendar - START -->
					<div id = "calendar">
					<div class="responsive-calendar">
						<div class="controls">
							<a class="pull-left" data-go="prev"><div class="btn btn-primary">Prev</div></a>
							<h4><span data-head-year></span> <span data-head-month></span></h4>
							<a class="pull-right" data-go="next"><div class="btn btn-primary">Next</div></a>
						</div><hr/>
						<div class="day-headers">
							
							<div class="dayHeader">Mon</div>
							<div class="dayHeader">Tue</div>
							<div class="dayHeader">Wed</div>
							<div class="dayHeader">Thu</div>
							<div class="dayHeader">Fri</div>
							<div class="dayHeader">Sat</div>
							<div class="dayHeader">Sun</div>
         
						</div>
						<div class="days" data-group="days">
          
						</div>
					</div>
					</div>
      <!-- Responsive calendar - END -->
				</div>
				<script src="../js/jquery.js"></script>
				<?php include '../js/responsive-calendar.php'; ?>
				<script type="text/javascript">

				
					$(document).ready(function () {
					$(".responsive-calendar").responsiveCalendar({
				
					});
					
					});
				</script>
			</div>
		</div>
		<?php include '../php_includes/footer.php'; ?>
	</body>
</html>