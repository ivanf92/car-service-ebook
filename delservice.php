<?php
header("Content-Type: application/json; charset=UTF-8");
$obj_svc = json_decode($_POST["x"], false);

if ($obj_svc == null) {
  echo "ERROR: Something went wrong!";
  exit();
}

include "settings.php";

$dbname = $obj_svc->val_dbname;
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "DROP TABLE ".$obj_svc->val_table;

if ($conn->query($sql) === TRUE) {
  echo "Table deleted successfully.";
} else {
  echo "Error deleting table: " . $conn->error;
}
$conn->close();
?>