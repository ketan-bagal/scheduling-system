<?php
$server="localhost";
$loginaccount="root";
$loginpasswd="";
$dbname="booking";
$conn = mysqli_connect($server, $loginaccount, $loginpasswd, $dbname);
if (mysqli_connect_errno())
{
  print "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
