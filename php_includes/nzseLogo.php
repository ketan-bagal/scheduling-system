<div id="nzseLogo">
<?php
	if(isset($_SESSION['usertype']))
	{
		if ($_SESSION['usertype']==1){
			print "	<a href='../admin_home/admin_home.php'>
		<img src='../pic/nzseLogo.png' alt='home'><h2>Scheduler</h2></a>";
		}
		else {
			print "	<a href='../user_home/user_home.php'>
		<img src='../pic/nzseLogo.png' alt='home'></a>";
		}
	}

?>
</div><!--nzse logo-->
