<?php
header("Content-Type: application/json; charset=UTF-8");
$obj_car = json_decode($_POST["x"], false);

if ($obj_car == null) {
  echo "ERROR: Something went wrong!";
  exit();
}

include "settings.php";

$dbname = "i_cars";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM `list` WHERE dbname = '" . $obj_car->val_dbname . "'";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
echo $row["name"] . "//" . $row["manufacturer"] . "//" . $row["additional"] . "//" . $row["year"] .
 "//" . $row["ccm"] . "//" . $row["power"];
}

$conn->close();
?>