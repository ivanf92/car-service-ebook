<?php
header("Content-Type: application/json; charset=UTF-8");
$obj_svc = json_decode($_POST["x"], false);

if ($obj_svc == null) {
  echo "ERROR: Something went wrong!";
  exit();
}

include "settings.php";

$dbname = $obj_svc->dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "DELETE FROM " . $obj_svc->name;
$conn->query($sql);
$conn->close();
?>