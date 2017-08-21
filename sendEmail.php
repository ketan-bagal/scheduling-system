<?php session_start(); ?>
<?php 
include 'php_script/connectDB.php';
if(isset($_SESSION['did']))
{
	$me = "Your booking has been refused";
$bid = $_SESSION['did'];
unset($_SESSION['did']);
}
if(isset($_SESSION['cid']))
{
	$me = "Your booking has been confirmed";
$bid = $_SESSION['cid'];
unset($_SESSION['cid']);
}

		$query = "SELECT b.*,user.email,user.userid FROM booking b,user WHERE user.userid = b.bookinguserid AND b.bookingid = '".$bid."'";
		if ($runquery = $conn->query($query))
		{
			while($row = $runquery->fetch_assoc())
			{
				$email = $row['email'];
				$b = $row['bookingid'];
				$userid = $row['userid'];
				$reason = $row['reason'];
				$email = $row['email'];
				$date = $row['date'];
				}
				}
				if(!$runquery)
				{
				$_SESSION['error'] = "email query";
			header('location: ../admin_home/admin_editbooking.php?fail='+1);
			exit();
				}
				$_SESSION['error'] .= $email;
		mysqli_close($conn);
		$txt = "
		<html>
		<style>
		table {margin-left:auto;margin-right:auto;text-align:center;}
		table th{background-color: #B0B0B0;}
		table.front td {text-align: left; width:180px;height:38px; padding-left:10px;}
		table.front th {font-size:14px; width:100px;}
		table,th,td {border: 1px solid black;border-collapse: collapse;}
		p {width:860px;}
		fieldset { width:900px;}
		</style><body><center><a href='http://www.nzse.ac.nz/'>
		<img src='http://www.careersexpo.org.nz/uploads/feusers/12227_image.jpg' width='25%' height='20%'></a></center>
		<h1>Booking Notification</h1>";
		
		
	
			
			$txt .= "
	<table class='front'>
		<tr>
			<th>User ID</th>
			<td>'$userid'</td>
			<th>Booking Date</th>
			<td>'$date'</td>
		</tr>
		<tr>
			<th>Reason</th>
			<td colspan='3'>'$reason'</td>
		</tr>
		<tr>
			<th>booking ID</th>
			<td>'$b'</td>
			<th>Assessment name</th>
			<td>rt</td>
		</tr>
		<tr>
			<th>Date</th>
			<td colspan='3'>trrt</td>
		</tr>
		<tr>
			<th>Comment</th>
			<td colspan='3'>$me.</td>
		</tr>
	</table><br /><center><fieldset>";
		
		 
		
			
	$txt .="<p><b>Disclaimer</b>: This email may contain legally privileged confidential information and is intended only for the named recipient. 
	If you are not the intended recipient any use, disclosure or copying of the message or attachment(s) is strictly prohibited. 
	If you have received this message in error please notify the sender immediately and destroy it and any attachment(s). 
	Any views expressed in this e-mail may be those of the individual sender and may not necessarily reflect the views of New 
	Zealand School of Education Limited.</p>
	<b>Please consider the environment before printing.</b></fieldset></center></body></html>";

		$subject = "Notification from NZSE system";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= 'From: <NZSEsystem@nzse.ac.nz>' . "\r\n";

		$flag = mail($email,$subject,$txt,$headers);
	?>
	
