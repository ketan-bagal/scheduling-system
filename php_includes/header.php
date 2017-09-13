
<div class="col-12 col-m-12"></div>
<?php
if($_SESSION["usertype"]==1)
{
echo "<a href='../admin_home/admin_home.php' class='header'><img src='../pic/logo.png'></a>";
}
else
{
	echo "<a href='../user_home/user_home.php' class='header'><img src='../pic/logo.png'></a>";
}
?>

<?php include '../php_includes/logoutbutton.php';?>
<div id='username'>
<?php
if($_SESSION["usertype"]==1)
{
echo "<a href='../user_home/editprofile.php' >";
}
else
{
	echo "<a href='../user_home/editprofile.php' >";
}
?>
<button class="show_bt user_home"type="button" name="button"><?php echo $_SESSION["userid"];?></button>
<!--<img src="../pic/username.png" alt="user icon" style="width:37px;height:37px;">-->
</a>
</div>
