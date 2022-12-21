<?php
header("Content-Type: application/json; charset=UTF-8");
$dbname = $_POST["x"];

include "settings.php";

$conn = new mysqli($servername, $username, $password, $dbname);
$dbname = mysqli_real_escape_string($conn, $dbname); //Remove special chars for mysql query
$sql = "DROP DATABASE `" . $dbname . "`";
$sql1 = "DELETE FROM `list` WHERE dbname='" . $dbname . "'";
$conn->query($sql);
$conn->select_db("i_cars");
$conn->query($sql1);
$conn->close();
?>