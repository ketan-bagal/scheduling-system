<?php
$server="localhost";
$loginaccount="orandcon_jimmy";
$loginpasswd="P@ssw0rd";
$dbname="orandcon_bookingsystem";
$conn = mysqli_connect($server, $loginaccount, $loginpasswd, $dbname);
if (mysqli_connect_errno())
{
  print "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
