<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Auto Servis</title>
<link rel="stylesheet" href="main.css">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="main.js"></script>
<style type="text/css">
.accordion {
  font-family: Arial, sans-serif;
  background-color: #b3b3b3;
  color: #00004d;
  cursor: pointer;
  padding: 18px 40px;
  width: 100%;
  border: 1px solid #b3b3ff;
  border-radius: 5px;
  text-align: left;
  outline: none;
  font-size: 1.4em;
  font-weight: bold;
  transition: 0.4s;
  overflow: hidden;
}

.active {
  background-color: #737373;
  color:  #e6f2ff;
}
.accordion:hover {
  background-color: #ccc;
  color: #00004d;
  box-shadow: 0 0 5px 5px rgba(0, 102, 255, 0.3);
}

.panel {
  font-family: Arial, sans-serif;
  padding: 10px 18px;
  display: none;
  background-color: #ccc;
  overflow: hidden;
}

.p_left {
  float: left;
}
.p_right {
  float: right;
}

#i_cascade, #l_cascade {
  font-size: 1.2em;
  cursor: pointer;
}
</style>
<script>
function CheckGroups(){
var tables = document.querySelectorAll(".cTable");
var panel = document.querySelectorAll(".panel");
for (let i = 0; i < tables.length; i++) {
    var tbodyRowCount = tables[i].tBodies[0].rows.length;
    if(tbodyRowCount < 3) {
      panel[i].previousElementSibling.remove();
      panel[i].remove();
    }
    }
}

function sendParam(dataElement, command) {
  let spanarr, sdb, stb;
  let url = parent.location.href;
  let span = dataElement.parentNode.previousSibling.previousSibling.innerHTML;
  spanarr = span.split("//");
  sdb = spanarr[0];
  stb = spanarr[1];
  parent.postMessage(command + "__" + span, parent.location.href);

  event.stopPropagation();
}
</script>
</head>
<body>
<?php

error_reporting(0);

$post_icars = $_GET["rld"]; //rld is sent by deleteService() function above

if($post_icars == null) {
$post_icars = $_POST["i_cars"]; }

include "settings.php";

if($post_icars == null || $post_icars == "") {
  include "nocar.html";
  exit();
} else {
  $dbname = $post_icars;
}
$conn = new mysqli($servername, $username, $password, $dbname);

function CreateAcc($service_type="normal") {
    global $fdate, $fkm, $row1, $result1, $total_price, $service_price, $dbname, $tables;

    switch($service_type){
      case "smalls":
      $phrase="<abbr title='Small service'><img src='res/service_small.png' width='50px' height='40px' style='padding-left:10px'></abbr>";
      break;
      case "bigs":
      $phrase="<abbr title='Big service'><img src='res/service_big.png' width='50px' height='40px' style='padding-left:10px'></abbr>";
      break;
      default:
      $phrase="";
    }
    echo "<button class='accordion'><span style='display:none'>".$dbname."//".$tables."</span><p class='p_left'>".$fdate.$phrase."</p><p class='p_right'><abbr title='Edit service' onclick='sendParam(this, &#34edit&#34)'><span style='height:100%;margin-top:2%'><i class='fas fa-edit'></i></span></abbr>&nbsp&nbsp<abbr title='Delete service' onclick='sendParam(this, &#34delete&#34)'><span style='height:100%;margin-top:2%'><i class='fas fa-trash-alt'></i></span></abbr>&nbsp&nbsp&nbsp".$fkm."</p></button>\n";
    echo "<div class='panel'><table><tr><th>Part name</th><th>Type</th><th>Manufacturer</th><th>Price</th><th>Note</th></tr>\n";

    while($row1 = $result1->fetch_assoc()) {
    $total_price = $total_price + $row1["price"];
    echo "<tr><td>".$row1["name"]."</td>"."<td>".$row1["type"]."</td>"."<td>".$row1["producer"]."</td>"."<td>".$row1["price"]."</td>"."<td>".$row1["note"]."</td></tr>\n";
    }
    echo "<tr style='border-right:none'><td></td><td></td><td style='text-align:right'><b>Total:</b></td><td><b>".$total_price."</b></td><td><b>Service price: ".$service_price."</b></td></tr>";
    echo "</table></div>\n";
}

function CreateGroups() {
  global $fdate, $fkm, $row1, $result1, $total_price, $service_price, $dbname;

  $post_group = $_POST["i_group"];

    echo "<button class='accordion'><p class='p_left'>".$fdate."</p><p class='p_right'>".$fkm."</p></button>\n";
    echo "<div class='panel'><table class='cTable'><tr><th>Part name</th><th>Type</th><th>Manufacturer</th><th>Price</th><th>Note</th></tr>\n";

    while($row1 = $result1->fetch_assoc()) {
    if($post_group == $row1["group"] || $post_group == "all") {
    $total_price = $total_price + $row1["price"];
    echo "<tr><td>".$row1["name"]."</td>"."<td>".$row1["type"]."</td>"."<td>".$row1["producer"]."</td>"."<td>".$row1["price"]."</td>"."<td>".$row1["note"]."</td></tr>\n";
    } }
    echo "<tr style='border-right:none'><td></td><td></td><td style='text-align:right'><b>Total:</b></td><td><b>".$total_price."</b></td><td><b>Service price: ".$service_price."</b></td></tr>";
    echo "</table></div>\n";
    echo "<script>CheckGroups()</script>";

}

$sql = "SHOW TABLES";
$result = $conn->query($sql);
if($_POST["i_view"] == null) {
  $post_view = "all";
} else {
  $post_view = $_POST["i_view"]; //SELECTED VIEW
}
if($_POST["i_group"] == null) {
  $group_view = "all";
} else {
  $group_view = $_POST["i_group"]; //SELECTED GROUP
}
$date_from = date_format(date_create($_POST["date_from"]), "Y-m-d");
$date_to = date_format(date_create($_POST["date_to"]), "Y-m-d");

while($row = $result->fetch_assoc()) {
  $tables = $row["Tables_in_" . $dbname];
  $table_array = explode("_", $tables);
  $sql1 = "SELECT * FROM " . $tables;
  $result1 = $conn->query($sql1);
  $fdate = date_format(date_create($table_array[2]),"d.m.Y"); //OUTPUT DATE FORMAT FOR ACC
  $fkm = number_format($table_array[0],0,",",".")." km"; //FORMAT KM OUTPUT
  $ref_date = date_format(date_create($table_array[2]), "Y-m-d");
  $total_price = 0;
  $service_price = $table_array[3];

  switch($post_view) {
    case "all":
    switch($table_array[1]) {
      case "b":
      CreateAcc("bigs");
      break;
      case "s":
      CreateAcc("smalls");
      break;
      default:
      CreateAcc();
    }
    break;

    case "bigs":
    if($table_array[1] == "b") {
    CreateAcc("bigs");
  }
    break;

    case "smalls":
    if($table_array[1] == "s") {
    CreateAcc("smalls");
    }
    break;

    case "date":
    if($_POST["date_from"] == "" || $_POST["date_to"] == "") {
      switch($table_array[1]) {
      case "b":
      CreateAcc("bigs");
      break;
      case "s":
      CreateAcc("smalls");
      break;
      default:
      CreateAcc();
    }
    break; //exit of the case "date"
    }
    if($date_from <= $ref_date && $ref_date <= $date_to) {
      switch($table_array[1]) {
      case "b":
      CreateAcc("bigs");
      break;
      case "s":
      CreateAcc("smalls");
      break;
      default:
      CreateAcc();
    }
  }
    break;

    case "group":
    CreateGroups();
    break;
}
}
$conn->close();
?>

<script>
var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>
</body>
</html>