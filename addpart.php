<?php
header("Content-Type: application/json; charset=UTF-8");
$obj_part = json_decode($_POST["x"], false);

if ($obj_part != null) {
$sel_car = $obj_part->car;
} else {
  echo "ERROR: Car not selected!";
  exit();
}

include "settings.php";

$table_name = $obj_part->tablename;
$dbname = $sel_car;
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "INSERT INTO `" . $table_name . "` VALUES ('" . $obj_part->name . "', '" . $obj_part->type . "', '" . $obj_part->producer . "', '" . $obj_part->price . "', '" . $obj_part->note . "', '" . $obj_part->group . "', '" . $obj_part->grouptext . "');";
if ($conn->query($sql) === TRUE) {
  echo "Data inserted successfully";
} else {
  echo "Error inserting data: " . $conn->error;
}
$conn->close();
?>