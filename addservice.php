<?php
header("Content-Type: application/json; charset=UTF-8");
$obj_service = json_decode($_POST["x"], false);

include "settings.php";

if($obj_service != null) {
$sel_car = $obj_service->val_car;
$dbname = $sel_car;
$conn = new mysqli($servername, $username, $password, $dbname);

$val_km = $obj_service->val_km;
$val_date = $obj_service->val_date;
$val_type = $obj_service->val_type;
$svc_price = $obj_service->svc_price;
$table_name = $val_km . "_" . $val_type . "_" . $val_date . "_" . $svc_price;
$sql = "CREATE TABLE `" . $table_name . "` (name varchar(40), type varchar(40), producer varchar(40), price int(20), note varchar(50), `group` varchar(20), `group_text` varchar(30));";
if ($conn->query($sql) === TRUE) {
  echo "Table " . $table_name . " created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}
$conn->close();
}
?>