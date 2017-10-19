<link rel="stylesheet" type="text/css" href="../css/a.css">
<div class="col-3 col-m-3 menu">
	<ul>
		<li>View / Edit</li>
		<?php
		if(isset($_SESSION["usertype"]))
		{
		if($_SESSION["usertype"]==1)
		{
		echo "<li><div class='dropdown'>
			<a href='../admin_home/admin_edituser.php' class='hvr-back-pulse'><span>User</span></a>
			<div class='dropdown-content'>
			<a href='../admin_home/admin_manageuser.php' class='hvr-back-pulse'><span class='dropbtn'>Manage User</span></a>
			</div>
			</div></li>";
		echo "<li><div class='dropdown'>
  <a href='../admin_home/admin_editroom.php' class='hvr-back-pulse'><span >Room</span></a>
  <div class='dropdown-content'>
    <a href='../admin_home/admin_editbuilding.php' class='hvr-back-pulse'><span class='dropbtn'>Building</span></a>
    <a href='../admin_home/admin_editcampus.php' class='hvr-back-pulse'><span class='dropbtn'>Campus</span></a>

  </div>
</div></li>";
		//echo "<li><a href='../admin_home/admin_editcampus.php' class='hvr-back-pulse'>Campus</a></li>";
		//echo "<li><a href='../admin_home/admin_editbuilding.php' class='hvr-back-pulse'>Building</a></li>";
		echo "<li><a href='../admin_home/admin_editholiday.php' class='hvr-back-pulse'>Holiday</a></li>";
		echo "<li><div class='dropdown'>
		<a href='../admin_home/admin_edittutor.php' class='hvr-back-pulse'>Tutor</a>
		<div class='dropdown-content'>
		<a href='../admin_home/admin_edittutorcorhortcourse.php' class='hvr-back-pulse'><span class='dropbtn'>Tutor <img src='../pic/link.png' alt='link' style='width:20px;height:20px;'> Course</span></a>
		<div>
		</div></li>";
		echo "<li><a href='../admin_home/admin_editschool.php' class='hvr-back-pulse'>School</a></li>";
		//echo "<li><a href='../admin_home/admin_editcohort.php' class='hvr-back-pulse'>Cohort</a></li>";
		echo "<li><div class='dropdown'>
  <a href='../admin_home/admin_editcohort.php' class='hvr-back-pulse'><span>Cohort</span></a>
  <div class='dropdown-content'>
		<a href='../admin_home/admin_editprogramme.php' class='hvr-back-pulse'><span class='dropbtn'>Programme</span></a>
		<a href='../admin_home/admin_editcourse.php' class='hvr-back-pulse'><span class='dropbtn'>Course</span></a>
		<a href='../admin_home/admin_editcampusprogramme.php' class='hvr-back-pulse'><span class='dropbtn'>Campus <img src='../pic/link.png' alt='link' style='width:20px;height:20px;'> Prog. </span></a>
		<a href='../admin_home/admin_editcourseprogramme.php' class='hvr-back-pulse'><span class='dropbtn'>Prog. <img src='../pic/link.png' alt='link' style='width:20px;height:20px;'> Course</span></a>
  </div>
</div></li>";
		/*echo "<li><a href='../admin_home/admin_editprogramme.php' class='hvr-back-pulse'>Programme</a></li>";
		echo "<li><a href='../admin_home/admin_editcourse.php' class='hvr-back-pulse'>Course</a></li>";

		echo "<li><a href='../admin_home/admin_editcampusprogramme.php' class='hvr-back-pulse'>Associate Programme with Campus</a></li>";
		echo "<li><a href='../admin_home/admin_editcourseprogramme.php' class='hvr-back-pulse'>Associate Programme with Course</a></li>";*/
		echo "</ul>";
		/*echo "<ul>";
		echo "<li>Adhoc Booking</li>";
		echo "<li><a href='../admin_home/admin_home.php' class='hvr-back-pulse'>Make Booking</a></li>";
		echo "<li><a href='../admin_home/admin_editbooking.php' class='hvr-back-pulse'>View Booking</a></li>";
		echo "</ul>";
		echo "<ul>";
		echo "<li>Recurring Booking</li>";
		echo "<li><a href='../admin_home/admin_recurring.php' class='hvr-back-pulse'>Make Booking</a></li>";
		echo "<li><a href='../admin_home/admin_editrecurring.php' class='hvr-back-pulse'>Edit Booking</a></li>";
		echo "<li><a href='../admin_home/admin_view_recurring.php' class='hvr-back-pulse'>View Booking</a></li>";
		echo "</ul>";*/
		echo "<ul>";
		echo "<li>Report</li>";
		echo "<li><a href='../admin_home/admin_viewreport_tutor.php' class='hvr-back-pulse'>Tutor</a></li>";
		//echo "<li><a href='../admin_home/admin_viewreport_room.php' class='hvr-back-pulse'>Room</a></li>";
		echo "<li><a href='../admin_home/admin_view_recurring_view.php?submit=1' class='hvr-back-pulse'>Room</a></li>";
		//echo "<li><a href='../admin_home/admin_viewganttchart.php' class='hvr-back-pulse'>Ganttchart</a></li>";
		}
		elseif($_SESSION["usertype"]==0)
		{
			echo "<li><a href='../user_home/user_home.php' class='hvr-back-pulse'>Adhoc Booking</a></li>";
			echo "<li><a href='../user_home/user_editbooking.php' class='hvr-back-pulse'>View Own Booking</a></li>";
			echo "<li><a href='../user_home/user_view_recurring.php' class='hvr-back-pulse'>View All Booking</a></li>";
		}
		elseif($_SESSION["usertype"]==2)
		{
			echo "<li><a href='../manager_home/manager_home.php' class='hvr-back-pulse'>Adhoc booking</a></li>";
			echo "<li><a href='../manager_home/manager_recurring.php' class='hvr-back-pulse'>Recurring Booking</a></li>";
			echo "<li><a href='../manager_home/manager_editbooking.php' class='hvr-back-pulse'>View My Adhoc Booking</a></li>";
			echo "<li><a href='../manager_home/manager_view_recurring.php' class='hvr-back-pulse'>View All Booking</a></li>";
		}
		}
		?>
	</ul>
	<br>
</div>
