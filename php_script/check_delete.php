<?php
include './connectDB.php';

$id=$_GET['id'];
$table=$_GET['table'];
$pkname=$_GET['pkname'];
if ($table == "cohort") {
  $sql1="DELETE FROM semester WHERE $pkname = '$id'";
  $result1 = mysqli_query($conn,$sql1);
}
$sql="DELETE FROM $table WHERE $pkname = '$id'";
$result = mysqli_query($conn,$sql);
if ($result) {
  echo "ture";
}else {
  echo "false";
}
mysqli_close($conn);
 ?>
