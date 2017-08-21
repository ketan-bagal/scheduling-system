<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<?php $title="Add user"; ?>
	<?php include '../php_includes/head_elements.php'; ?>
	<?php include '../php_includes/alertbox.php'; ?>
</head>
<body>
<div id="page-container">
			<?php include '../php_includes/header.php'; ?>
			<?php include '../php_includes/nav.php'; ?>
			<div class="col-6 col-m-9 content">
				<h1>Add User</h1>

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
<form id="form1" action="./admin_adduser_script.php" method="post">
<fieldset>
<?php echo "";if(!isset($_GET['edit'])) {echo "<input type='text' name='userid' placeholder='User name' value='";}
if(isset($_SESSION['uid'])) {echo $_SESSION['uid'];}
if(!isset($_GET['edit'])) {echo "'>";}
?>
<label for='usertype'>User type:</label>
<label for='usertype'>
<input type="radio" name="usertype" value="1" >Admin</label>
<label><input type="radio" name="usertype" value="2" >Manager</label>
<label><input type="radio" name="usertype" value="0" >User</label><br />
<input type="text" name="email" placeholder="Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'];?>">

</fieldset>

<?php if(isset($_GET['edit'])) {echo "<input type='submit' name='submit' value='submit'>";$_SESSION['updatingid']=$_SESSION['uid'];}
else {echo "<input type='submit' name='new' value='submit'>";}
  ?>

</form>
</div>
</div>
		</div>
		</div>
<script>
	$("#form1").on('submit', function ()
		{
			var flag;
			var d = 5000;
			var userid = document.forms["form1"]["userid"].value;
			if (userid == null || userid == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Username is required");
				flag=false;
			}
			var email = document.forms["form1"]["email"].value;
			if (email == null || email == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Email is required");
				flag=false;
			}else{
				 var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				 if(!regex.test(email))
				 {
					 d += 500;
					alertify.set({ delay: d });
					alertify.log("Please enter correct email.");
					flag=false;
				 }
			}
			
			var usertype = document.getElementsByName('usertype');
			var usertype_value="";
			for(var i = 0; i < usertype.length; i++){
				if(usertype[i].checked){
					usertype_value = usertype[i].value;
				}
			}
			if (usertype_value == null || usertype_value == "")
			{
				d += 500;
				alertify.set({ delay: d });
				alertify.log("Usertype is required.");
				flag=false;
			}

			return flag;
		});
		</script>

<?php
	unset($_SESSION['uid'],$_SESSION['email']);
?>
<br><br>

<?php include '../php_includes/footer.php';?>

</body>
</html>
