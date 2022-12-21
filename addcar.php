<?php
header("Content-Type: application/json; charset=UTF-8");
$obj_part = json_decode($_POST["x"], false);

if ($obj_part == null) {
  echo "ERROR: Something went wrong!";
}

include "settings.php";

$dbname = "i_cars";
$conn = new mysqli($servername, $username, $password, $dbname);
$model_input = str_replace(" ", "", $obj_part->val_model);
$model_input = strtolower($model_input);
$manufacturer_input = str_replace(" ", "", $obj_part->val_mfc);
$manufacturer_input = str_replace("-", "", $manufacturer_input);
$manufacturer_input = strtolower($manufacturer_input);
$dbname_input = "i_" . $manufacturer_input . "_" . $model_input . $obj_part->match;
$dbname_input = mysqli_real_escape_string($conn, $dbname_input); //Remove special chars for mysql query
$sql = "INSERT INTO `list` VALUES ('" . $dbname_input . "', '" . $obj_part->val_model . "', '" . $obj_part->val_mfc . "', '" . $obj_part->val_add . "', '" . $obj_part->val_year . "', '" . $obj_part->val_ccm . "', '" . $obj_part->val_power . "');";
//Add car data into list table in i_cars database
if ($conn->query($sql) === TRUE) {
  echo "Data inserted successfully<br>";
} else {
  echo "Error inserting data: " . $conn->error;
}
$conn->close();
//Create car database
$conn = new mysqli($servername, $username, $password);
$sql = "CREATE DATABASE IF NOT EXISTS `" . $dbname_input . "`";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}
$conn->close();
?>