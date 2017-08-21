<div id="menu">
<?php
	if(isset($_SESSION['usertype']))
	{
		if ($_SESSION['usertype']==1){
			print "<a href='../admin_home/admin_home.php'>Admin page</a>";
		}
		else {
			print "<a href='../user_home/user_home.php'>User page</a>";
		}
	}

?>
</div><!--menu-->