<!DOCTYPE html>
<html lang="sr-RS">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Ivan Filipović">
<title>Car Service E-book</title>
<script src="main.js"></script>
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="select.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body id="body1">
<?php
include "settings.php";

$dbname = "i_cars";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM list";
$result = $conn->query($sql);
?>
<div class="div_main">

<form id="form_menu" class="form_view" method="post" target="iframe_table" action="data.php">
<div id="div_menu" style="display:flex;z-index:1;height:50px;align-items:center;">
&nbsp&nbsp
<div id="cust_cars" class="custom-select" onclick="selectView('car')" style="width:250px">
  <select id="i_cars" name="i_cars">
    <option value="0">Choose a car:</option>
<?php
while($row = $result->fetch_assoc()) {
  $fullname = $row["manufacturer"] . " " . $row["name"] . " " . $row["additional"];
  if (strlen($fullname) > 26) {
    $fullname = substr($fullname, 0 , 24) . "...";
  }
  echo "<option value='" . $row["dbname"] . "'>" . $fullname . "</option>";
}
?>
  </select>
</div>&nbsp&nbsp

<div id="span_view" onclick="viewGroup();selectView('view');setCurrentDate()" class="custom-select" style="width:200px;">
  <select id="i_view" name="i_view">
    <option value="0">Show:</option>
    <option value="all">All</option>
    <option value="date">Specific period</option>
    <option value="bigs">Big services</option>
    <option value="smalls">Small services</option>
    <option value="group">By part group</option>
  </select>
</div>&nbsp&nbsp

<div id="span_date" style="height:40px">
<span class="a_label">&nbsp&nbspfrom:&nbsp</span>
<input type="date" id="date_from" name="date_from" style="background-color:#e0ebeb;height:90%;width:9vw" onchange="selectView();closeDate(false)" onkeydown="pressEnter(document.getElementById('date_to'))">
<span class="a_label">&nbsp&nbspto:&nbsp</span>
<input type="date" id="date_to" name="date_to" style="background-color:#e0ebeb;height:90%;width:9vw" onchange="selectView();closeDate(false)">&nbsp
<button onclick="closeDate(true)" style="border:none;width:11%;height:90%;background-color:dodgerblue;color:white;font-size:1em;cursor:pointer;">X</button>
</div>

<div id="span_group" class="custom-select" onclick="selectView()" style="display:none;width:200px;">
<select id="i_group" name="i_group">
<option value="0">Choose a group:</option>
<option value="all">All</option>
<option value="engine">Engine</option>
<option value="turbo">Turbo and air flow</option>
<option value="gearbox">Gearbox</option>
<option value="clutch">Clutch</option>
<option value="transmission">Transmission</option>
<option value="exhaust">Exhaust</option>
<option value="suspension">Suspension</option>
<option value="body">Body</option>
<option value="electric">Electrics</option>
<option value="electronic">Electronics</option>
<option value="coolant">Cooling</option>
<option value="fuel">Fuel system</option>
<option value="heat">Heating / Ventilation</option>
</select>
</div>&nbsp&nbsp

<button class="button_blue" style="font-size:1em;" onclick="openModal();listParts()"><i class="fas fa-plus" style="color:green"></i>  <i class="fas fa-wrench"></i>  Add service</button>&nbsp&nbsp
<button class="button_blue" style="font-size:1em;" onclick="newCar()"><i class="fas fa-plus" style="color:green"></i>  <i class="fas fa-car"></i>  Add car</button>
</div>

<br>
<div id="div_menu_low" style="display:flex;width:92%;height:50px;justify-content: flex-start; align-items: flex-start;">

<p style="width:50px"></p>
<button id="btn_car" class="menu_button" onclick="openCarInfo()"><abbr title="Car info"><i style="font-size:1.8vw" class="fas fa-info"></i><i style="font-size:2.5vw" class="fas fa-car"></i></abbr></button>
<p style="width:20px"></p>
<button id="btn_car" class="menu_button" onclick="sendDeleteCar()"><abbr title="Delete car"><i style="font-size:1.8vw" class="fas fa-trash-alt"></i><i style="font-size:2.5vw" class="fas fa-car"></i></abbr></button>

<p style="width:110px"></p>
<abbr id="abb_coll" onclick="fCascade()" title="Collapse"><div id="btn_casc" class="menu_button" style="display:flex;justify-content:space-evenly;"><input type="checkbox" id="i_cascade" hidden>
<label id="l_cascade" for="i_cascade" style="text-align:center; width:30%;cursor:pointer;"><i id="coll_arrow" style="font-size:2.5vw;" class="fas fa-angle-double-down"></i></label></div></abbr>

</div>

</form>

<div class="content">
<iframe src="data.php" id="iframe_table" name="iframe_table" width="100%" height="1000px"></iframe>
</div>
</div>

<div id="div_modal" class="modal">
<div class="modal-content">
<div class="modal-header">
<span id="svc_header" style="float:left;padding-left:15px;font-size:18px;color:#00264d"><b><i class="fas fa-wrench"></i>&nbsp&nbspNew service for&nbsp<span id="selcar"></span></b></span>
<span style="float:right;"><button id="btn_close" onclick="closeDialog()">X</button></span>
</div><br>

<span style="padding-left:50px">
<label for="inp_date" style="margin-top:5px;">Date:</label>
<input type="date" style="background-color: #e0ebeb;" id="inp_date" onkeydown="pressEnter(document.getElementById('inp_km'))" onchange="changeStatus()" onfocus="unRed(this)">&nbsp&nbsp
<label for="inp_km" style="margin-top:5px;">Mileage:</label>
<input type="text" id="inp_km" style="background-color: #e0ebeb;" maxlength="7" size="7" pattern="[0-9]+" onkeydown="pressEnter(document.getElementById('inp_service'))" onchange="changeStatus()" onfocus="unRed(this)">&nbsp&nbsp
<label for="inp_service">Service type:</label>
<select id="inp_service" style="background-color: #e0ebeb;" onkeydown="pressEnter(document.getElementById('inp_svcprice'))" onchange="changeStatus()">
  <option value="n">Normal service</option>
  <option value="s">Small service</option>
  <option value="b">Big service</option>
</select>&nbsp&nbsp
<label for="inp_svcprice">Service price:</label>
<input type="text" value="0" style="background-color: #e0ebeb;" id="inp_svcprice" min="0" max="999999" size="7" maxlength="7" onkeydown="pressEnter(document.getElementById('inp_group'))"  onchange="changeStatus()" onfocus="unRed(this)">&nbspEUR
<label id="lbl_status" style="display:none;">none</label>
<label id="lbl_edit" style="display:none;">no</label>
</span><br><br><br>

<div class="div-content">
<div style="width:15%;text-align:right;">
<label for="inp_group" style="margin-top:8px;">Part group:&nbsp</label><br><br><br>
<label for="inp_part">Part name:&nbsp</label><br><br>
<label for="inp_type" style="margin-top:12px;">Type:&nbsp</label><br><br>
</div>

<div style="width:35%;">
  <select id="inp_group" onchange="listParts();changeStatus()" onkeydown="pressEnter(document.getElementById('inp_parttext'))">
    <option value="all">All</option>
    <option value="engine">Engine</option>
    <option value="turbo">Turbo and air flow</option>
    <option value="gearbox">Gearbox</option>
    <option value="clutch">Clutch</option>
    <option value="transmission">Transmission</option>
    <option value="exhaust">Exhaust</option>
    <option value="suspension">Suspension</option>
    <option value="body">Body</option>
    <option value="electric">Electrics</option>
    <option value="electronic">Electronics</option>
    <option value="coolant">Cooling</option>
    <option value="fuel">Fuel system</option>
    <option value="heat">Heating / Ventilation</option>
  </select><br><br>
  <input class="input-list" list="inp_part" id="inp_parttext" onkeydown="pressEnter(document.getElementById('inp_type'))" maxlength="40" size="30" onchange="changeStatus()" onfocus="unRed(this, false)">
  <datalist id="inp_part">
  </datalist><br><br>
  <input type="text" id="inp_type" onkeydown="pressEnter(document.getElementById('inp_prodtext'))" maxlength="40" size="30" onchange="changeStatus()"><br><br>
</div>

<div style="width:15%;text-align:right;">
<label for="inp_producer" style="margin-top:7px;">Manufacturer:&nbsp</label><br><br>
<label for="inp_price" style="margin-top:12px;">Price:&nbsp</label><br><br>
<label for="inp_note" style="margin-top:8px;">Note:&nbsp</label>
</div>

<div style="width:35%;">
  <input class="input-list" onkeydown="pressEnter(document.getElementById('inp_price'))" list="inp_producer" style="font:1em Arial;padding:5px 10px;" id="inp_prodtext" maxlength="30" size="30" onchange="changeStatus()">
  <datalist id="inp_producer">
  </datalist><br><br>
  
  <input type="text" value="0" id="inp_price" size="7" maxlength="7" min="0" max="999999" onkeydown="pressEnter(document.getElementById('inp_note'))" onchange="changeStatus()" onfocus="unRed(this, false)">&nbspEUR<br><br>
  <textarea id="inp_note" onkeydown="pressEnter(document.getElementById('btn_add'))" rows="3" cols="30" style="resize:none;" maxlength="60" onchange="changeStatus()"></textarea><br><br>
  <button class="button_blue" id="btn_add" onclick="queuePart()">Add part</button>

</div>
</div>
<br>

<label for="inp_changed" style="margin-left:11%;">Changed parts:&nbsp</label>
<div class="flex-container">
<div id="table-container" style="width:90%;">
  <table id="inp_changed" class="table_data">
  <thead>
  <tr>
    <th width="20%">Name</th><th width="20%">Type</th><th width="15%">Group</th><th width="15%">Producer</th><th width="10%">Price</th><th width="20%">Note</th>
  </tr>
</thead>
</table>
</div>

<div style="float:left;width:15%;">
<br><br>
<button style="height:30px;font-size:16px;" class="button_blue" onclick="unqueuePart()">Delete</button> <br><br>
<button id="btn_select" style="height:30px;font-size:16px;" class="button_blue" onclick="tableSelectAll()">Select all</button> <br><br><br>

</div>
</div>
<div style="width:100%;padding-top:5px;">
  <button class="button_green" onclick="addService()">Save</button>
</div>
</div>
</div>

<div id="custom_alert" class="custom-alert">
<div id="alert_content" class="alert-content">
  <div class="alert-header">
    <span id="alert_title" style="float:left;padding-top:5px;"><b>TITLE</b></span>
    <span style="float:right">
    <button id="btn_closealert" class="button_blue" onclick="closeAlert();reloadPage()">X</button></span>
  </div>
    <div class="alert-body">
      <p id="alert_msg" style="padding-left:10px">
      </p>
    </div>
  <div class="alert-footer">
    <div>
      <button id="btn_yes" class="button_blue" style="width:80px;font-size:16px;" onclick="deleteService(delete_data);deleteCar();closeAlert();closeModal()">Yes</button>
      <button id="btn_ok" class="button_blue" style="width:100px;font-size:16px;" onclick="closeAlert();reloadPage()">OK</button>
      <button id="btn_no" class="button_blue" style="width:80px;font-size:16px;" onclick="closeAlert();delete_data=null;">No</button>
    </div>
  <label id="lbl_action" style="display:none"></label>
  </div>
</div>
</div>

<div id="div_car" class="modal">
  <div class="modal-content" style="width:50%;height:320px;">
    <div class="modal-header">
      <span style="float:left;padding-left:15px;font-size:18px;color:#00264d"><b id="car_header"><i class="fas fa-car"></i>&nbsp&nbspNew car</b></span>
      <span style="float:right;"><button id="btn_close" onclick="closeNewCar()">X</button></span>
    </div><br>

<div class="div-content">
<div style="width:20%;text-align:right;">
<label for="inp_manufacturer" style="margin-top:8px;">Manufacturer:&nbsp</label><br><br><br>
<label for="inp_additional">Additional:&nbsp</label><br><br>
<label for="inp_ccm" style="margin-top:12px;">Displacement:&nbsp</label><br><br>
</div>

<div style="width:25%;">
  <select id="inp_manufacturer" onchange="listParts();changeStatusCar()" onkeydown="pressEnter(document.getElementById('inp_model'))" onclick="showOther(true);unRed(this, false)">
    <option value="" disabled selected hidden>Choose manufacturer:</option>
    <option>Alfa Romeo</option>
    <option>Audi</option>
    <option>BMW</option>
    <option>Citroen</option>
    <option>Dacia</option>
    <option>Fiat</option>
    <option>Ford</option>
    <option>Honda</option>
    <option>Hyundai</option>
    <option>Mazda</option>
    <option>Mercedes-Benz</option>
    <option>Nissan</option>
    <option>Opel</option>
    <option>Peugeot</option>
    <option>Renault</option>
    <option>Seat</option>
    <option>Škoda</option>
    <option>Suzuki</option>
    <option>Toyota</option>
    <option>Volvo</option>
    <option>Volkswagen</option>
    <option>Zastava</option>
    <option value="other">Other</option>
  </select><br><br>
  <input type="text" id="inp_other" onkeydown="pressEnter(document.getElementById('inp_model'))" maxlength="20" size="22" onclick="unRed(this, false)" onchange="changeStatusCar()" placeholder="Type manufacturer name" style="display:none;">
  <input type="text" id="inp_additional" onkeydown="pressEnter(document.getElementById('inp_year'))" maxlength="20" size="22" onchange="changeStatusCar()"><br><br>
  <input type="text" id="inp_ccm" onkeydown="pressEnter(document.getElementById('inp_power'))" maxlength="5" size="5" onchange="changeStatusCar()">&nbspccm<br><br>
</div>
<div style="width:20%;text-align:right;">
<label for="inp_model" style="margin-top:8px;">Model:&nbsp</label><br><br><br>
<label for="inp_year">Year:&nbsp</label><br><br>
<label for="inp_power" style="margin-top:12px;">Power:&nbsp</label><br><br>
</div>

<div style="width:35%;">
  <input type="text" id="inp_model" onkeydown="pressEnter(document.getElementById('inp_additional'))" maxlength="20" size="20" onchange="changeStatusCar()" onclick="unRed(this, false)"><br><br>
  <input type="text" id="inp_year" onkeydown="pressEnter(document.getElementById('inp_ccm'))" maxlength="4" size="4" onchange="changeStatusCar()"><br><br>
  <input type="text" id="inp_power" onkeydown="pressEnter(document.getElementById('btn_savecar'))" maxlength="4" size="4" onchange="changeStatusCar()">&nbspkW (hp)<br><br>
</div>
<label id="lbl_status_car" style="display:none;">none</label>
  </div>
<div style="width:100%;padding-top:20px;">
  <button id="btn_savecar" class="button_green" onclick="addCar()">Save</button>
</div>
</div>
</div>

<script>
var x, i, j, l, ll, selElmnt, a, b, c, span, ns, f;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    span = "<span style='display:none'>" + selElmnt.options[j].value + "</span>";
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML + span;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        ns = this.getElementsByTagName("span")[0];
        for (i = 0; i < sl; i++) {
            if (s.options[i].value == ns.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);

function reloadPage() {
  let arr, base_url;
  if (delete_data == null) {
    return;
  }
  if (delete_data == "delete_car") {
    location.replace(location.href);
    return;
  } else {
  arr = location.href.split("?rld=");
  //Check if there is already ?rld in url and clear it
  if (arr.length > 0) {
    base_url = arr[0];
  } else {
    base_url = location.href;
  }
  arr = delete_data.split("//"); // delete_data is global variable (main.js)
  location.replace(base_url + "?rld=" + arr[0]);
  }
}

//STICKY
window.onscroll = function() {setDatePosition();setSticky()};
var div_menu = document.getElementById("div_menu");
var div_menu_low = document.getElementById("div_menu_low");
var div_date = document.getElementById("span_date");
var sticky = div_menu.offsetTop;

//LOAD LAST CAR SELECTED
window.onload = function() {
let sel = document.getElementById("i_cars");
sel.selectedIndex = localStorage.getItem("ic_selcar");
document.getElementsByClassName('select-selected')[0].textContent = sel.options[sel.selectedIndex].text;
//Set view to ALL
sel = document.getElementById("i_view");
document.getElementsByClassName('select-selected')[1].textContent = sel.options[1].text;
selectView("car");
};

window.addEventListener('message', function (event) {
  let msg_arr;
  msg_arr = event.data;
  msg_arr = msg_arr.split("__");

  // If delete command is sent
  if(msg_arr[0] == "delete") {
  delete_data = msg_arr[1]; // delete_data is global variable (main.js)
  customAlert("confirm", "<i class='fas fa-exclamation-triangle' style='font-size:1.8vw;color:red'></i>&nbsp&nbsp"
     + "Are you sure you want to delete the service?<br><br>All service data will be deleted!");
  }
  // If edit command is sent
  if(msg_arr[0] == "edit") {
  editService(msg_arr[1] + "//" + msg_arr[2]);
  }
});
</script>
</body>
</html>