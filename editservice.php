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
$sql = "SELECT * FROM ".$obj_svc->val_table;
$result = $conn->query($sql);

echo $result->num_rows . "\n";
while($row = $result->fetch_assoc()) {
echo $row["name"] . "//" . $row["type"] . "//" . $row["producer"] . "//" . $row["price"] .
 "//" . $row["note"] . "//" . $row["group"] . "//" . $row["group_text"] . "\n";
}
$conn->close();
?>