<?php
include '../php_script/connectDB.php';
$table = $_GET["table"];
$sql = "UPDATE $table set ".$_GET["column"]."='".$_GET["value"]."' WHERE  ".$table."id='".$_GET["id"]."'";
mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
echo "saved";
?>
