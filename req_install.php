<?php
//error_reporting(0);
header("Content-Type: application/json; charset=UTF-8");

include "settings.php";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
	die("fail//Neuspela konekcija " . $conn->connect_error);
}

$sql = "SELECT SCHEMA_NAME
		FROM INFORMATION_SCHEMA.SCHEMATA
		WHERE SCHEMA_NAME = 'i_cars'";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    echo "fail//Application is installed already!";
    $conn->close();
} else {
    Install();
}

function Install() {
$conn = new mysqli("localhost", "root", "");
$sql = "CREATE DATABASE IF NOT EXISTS i_cars";
$conn->query($sql);
$conn->select_db("i_cars");
$sql = "CREATE TABLE IF NOT EXISTS list (dbname VARCHAR(30), name VARCHAR(30),
	manufacturer VARCHAR(30), additional VARCHAR(30),
	year INT(4), ccm INT(5), power INT(5))";

if ($conn->query($sql) === TRUE) {
	echo "success//";
	echo "Installed successfully.<br>Enjoy the app.";
} else {
	echo "fail//";
	echo "Installation failed!<br>" . $conn->connect_error;
}

$conn->close();
}
?>