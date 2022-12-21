var global_car, table_selected = "none", delete_data;

function setCurrentDate() {
  d = new Date();
  dd = d.getDate();
  if (dd < 10) {
    dd = "0" + dd;
  }
  dm = Number(d.getMonth() + 1);
  dy = d.getFullYear();
  d = dy + "-" + dm + "-" + dd;
  document.getElementById("date_to").value = d;
}

function setSticky() {
  if (window.pageYOffset >= sticky) {
    div_menu.classList.add("sticky")
    div_date.classList.add("sticky-date");
    div_menu_low.classList.add("sticky-low")
    div_menu_low.style.top = "50px";
  } else {
    div_menu.classList.remove("sticky");
    div_menu_low.classList.remove("sticky-low")
    div_date.classList.remove("sticky-date");
  }
}

function viewDate() {
	let car = document.getElementById("i_cars");
	let selected = document.getElementById("i_view");
  let div = document.getElementById("span_date");

	if(car.value != 0) {
	if (selected.value == "date") {
  div.style.display = "flex";
  setDatePosition();
  } else {
  closeDate(true);
	}
}
}

function setDatePosition() {
  let div = document.getElementById("span_date");
  let ref = document.getElementById("span_view") // Referent div element
  let menu_low = document.getElementById("div_menu_low");
  const rect = ref.getBoundingClientRect();
  div.style.position = "absolute";
  div.style.top = rect.top + rect.height + "px";
  div.style.left = rect.left + "px";
  div.style.height = "50px";
  menu_low.style.top = "50px";
}

function closeDate(force) {
  let date = document.getElementById("span_date");
  let date_from = document.getElementById("date_from").value;
  let date_to = document.getElementById("date_to").value;
  let year_arr = date_to.split("-");
  let year = year_arr[0];
  if (force == true) {
  date.style.height = 0;
  date.style.display = "none";
  } else if (date_from.length > 9 && year > 1900) {
    date.style.height = 0;
    date.style.display = "none";
  }
}

function viewGroup() {
	let car = document.getElementById("i_cars");
	let selected = document.getElementById("i_view");
	if(car.value != 0) {
	if (selected.value == "group") {
	document.getElementById("span_group").style.display = "inline"; }
	else {
	document.getElementById("span_group").style.display = "none";
	}
}
}

function selectView(selector) {
  let sel_view = document.getElementById("i_view").selectedIndex;
  let sel_cars = document.getElementById("i_cars").selectedIndex;

  if(selector == "car" && sel_view == 0){
    document.getElementById("i_view").value = "all";
    document.getElementById("i_view").selectedIndex = 1;
    document.getElementById("i_group").selectedIndex = 1;
    document.getElementById("form_menu").submit();
    window.scrollBy(0, 0 - window.pageYOffset);
    window.localStorage.setItem("ic_selcar", sel_cars);
  }
  if(selector == "view" && sel_cars <= 0) {
    customAlert("alert", "Choose a car!");
  } else {
    document.getElementById("form_menu").submit();
    viewDate();
    window.localStorage.setItem("ic_selcar", sel_cars);
    }
}

function fCascade(){
let ifObject = document.getElementById("iframe_table");
let ifDoc = ifObject.contentWindow.document;
let acc = ifDoc.getElementsByClassName("accordion");
let chkStatus = document.getElementById("i_cascade").checked;
let i, panel;

if (chkStatus == true) {
  for (i = 0; i < acc.length; i++) {
    panel = acc[i].nextElementSibling;
    panel.style.display = "block";
    acc[i].classList.add("active");
    document.getElementById("btn_casc").classList.add("collapsed");
    document.getElementById("coll_arrow").setAttribute("class", "fas fa-angle-double-up");
    document.getElementById("abb_coll").setAttribute("title", "Shrink all");
    }
  } else {

  for (i = 0; i < acc.length; i++) {
    panel = acc[i].nextElementSibling;
    panel.style.display = "none";
    acc[i].classList.remove("active");
    document.getElementById("btn_casc").classList.remove("collapsed");
    document.getElementById("coll_arrow").setAttribute("class", "fas fa-angle-double-down");
    document.getElementById("abb_coll").setAttribute("title", "Collapse all");
    }
  }
}

function openModal() {
  let dbname = document.getElementById("i_cars").value;
  let carname = document.getElementsByClassName('select-selected')[0].innerHTML;
  //If no car selected exit function and show alert
  if (dbname == "" || dbname == "0") {
    customAlert("alert", "You have to choose a car!");
    return;
  }
  global_car = dbname;
  document.getElementById("div_modal").style.display = "block";
  document.getElementById("selcar").innerHTML = carname;
  document.getElementById("body1").style.overflow = "hidden";
  //Set current date
  const d = new Date();
  let dateYear = d.getFullYear();
  let dateMonth = Number(d.getMonth()) + 1;
  if(dateMonth < 10) {
    dateMonth = "0" + dateMonth;
  }
  let dateDay = Number(d.getDate());
  if(dateDay < 10) {
    dateDay = "0" + dateDay;
  }
  let dateValue = dateYear + "-" + dateMonth + "-" + dateDay;
  document.getElementById("inp_date").value = dateValue;
  document.getElementById("inp_date").focus();
}

function closeModal() {
  resetInput();
  showOther(false); //Reset other manufacturer field in new car window
  document.getElementById("inp_date").disabled = false;
  document.getElementById("inp_km").disabled = false;
  document.getElementById("inp_service").disabled = false;
  document.getElementById("inp_svcprice").disabled = false;
  document.getElementById("lbl_edit").innerHTML = "no";

  document.getElementById("div_modal").style.display = "none";
  document.getElementById("div_car").style.display = "none";
  document.getElementById("body1").style.overflow = "visible";
  selectView("car");
}

function closeDialog() {
  let status, edit, alertMsg, table, rowscount;
  status = document.getElementById("lbl_status").innerHTML;
  edit = document.getElementById("lbl_edit").innerHTML;
  table = document.getElementById("inp_changed");
  rowscount = table.rows.length;
  if(rowscount > 1) {
    status = "changed";
  }
  alertMsg = "You didn't save the changes! <br><br> Are you sure you want to close the input?";
  if(status != "changed") {
  closeModal();
  } else {
    customAlert("confirm", alertMsg);
  }
}

function closeNewCar() {
  let status = document.getElementById("lbl_status_car").innerHTML;
  let alertMsg = "You didn't save the changes! <br><br> Are you sure you want to close the input?";
  let header = document.getElementById("car_header");
  let model = document.getElementById("inp_model");
  let manufacturer = document.getElementById("inp_manufacturer");
  let add = document.getElementById("inp_additional");
  let year = document.getElementById("inp_year");
  let ccm = document.getElementById("inp_ccm");
  let power = document.getElementById("inp_power");
  let btn_ok = document.getElementById("btn_savecar");

  header.innerHTML = "<i class='fas fa-car'></i>&nbsp&nbspNew car";
  manufacturer.value = "";
  manufacturer.disabled = false;
  model.value = "";
  model.disabled = false;
  add.value = "";
  add.disabled = false;
  year.value = "";
  year.disabled = false;
  ccm.value = "";
  ccm.disabled = false;
  power.value = "";
  power.disabled = false;
  btn_ok.innerHTML = "Save";
  btn_ok.setAttribute("onclick", "addCar()");

  if (status !="changed") {
    closeModal();
  } else {
    customAlert("confirm", alertMsg);
  }
}

function listParts() {
  let selArray;
  let arrAll = [];
  let group = document.getElementById("inp_group").value;
  const arrProducers = ["Castrol", "Bosch", "Delphi", "Valeo", "Febi bilstein", "Swag", "Ferodo",
  "Textar", "SKF", "Champion", "Filtron", "Monroe", "Total", "TRW", "Luk", "Sachs", "BluePrint",
  "Goetze", "Beru", "Brembo", "Mobil", "Elf", "Dayco", "INA", "Continental"];
  arrProducers.sort() //Sort producers by name
  const arrEngine = ["Engine oil", "Oil filter", "Piston", "Piston rod", "Crankshaft", "Camshaft",
    "Valves", "Engine head", "Engine head gasket", "Crankcase gasket"];
  const arrTurbo = ["Air filter", "Turbo charger", "Intercooler", "Intake manifold", "Intake pipes and hoses",
    "Air filter housing"];
  const arrGearbox = ["Gear oil", "Selector lever bushings", "Selector lever", "Selection bar",
    "Selection cable", "synchronous ring"];
  const arrClutch = ["Clutch set", "Friction plate", "Thrust bearing", "Clutch basket",
    "Master cylinder", "Secondary cylinder"];
  const arrTransmission = ["Differential", "Half shaft", "CV joint"];
  const arrExhaust = ["Exhaust pipe", "Catalyst", "DPF", "EGR Valve"];
  const arrSuspension = ["Steering bond", "Shock absorber", "Shock absorber cup", "Silent block",
    "Balance bar", "Balance bar rubber"];
  const arrBody = ["Hood", "Door", "Front bumper", "Rear bumper", "Windscreen", "Window", "Mirror",
    "Headlight", "Taillight"];
  const arrElectrics = ["Battery", "Starter motor", "Generator", "Fuse", "Relay", "Bulb",
   "Main light switch", "Brake light switch", "Wiper motor"];
  const arrElectronics = ["Main CPU", "Fuel Injection CPU", "Sensor", "Relay"];
  const arrCooling = ["Coolant", "Coolant radiator", "Radiator fan", "Hose", "Thermostat",
    "Coolant container"];
  const arrFuel = ["Fuel pump", "Nozzle", "Fuel filter", "Hoses"];
  const arrHeat = ["Cabin filter", "Heating fan", "Heating radiator"];

  switch(group) {
    case "all":
    arrAll = arrEngine.concat(arrTurbo, arrGearbox, arrClutch, arrTransmission, arrExhaust, arrSuspension,
      arrBody, arrElectrics, arrElectronics, arrCooling, arrFuel, arrHeat);
    selArray = [...arrAll];
    break;
    case "engine":
    selArray = [...arrEngine];
    break;
    case "turbo":
    selArray = [...arrTurbo];
    break;
    case "gearbox":
    selArray = [...arrGearbox];
    break;
    case "clutch":
    selArray = [...arrClutch];
    break;
    case "transmission":
    selArray = [...arrTransmission];
    break;
  case "exhaust":
    selArray = [...arrExhaust];
    break;
  case "suspension":
    selArray = [...arrSuspension];
    break;
  case "body":
    selArray = [...arrBody];
    break;
  case "electric":
    selArray = [...arrElectrics];
    break;
  case "electronic":
    selArray = [...arrElectronics];
    break;
  case "cooling":
    selArray = [...arrCooling];
    break;
  case "fuel":
    selArray = [...arrFuel];
    break;
  case "heat":
    selArray = [...arrHeat];
    break;
  }

  var selMenu = document.getElementById("inp_part");
  var option = "";
  //Create parts list
  for(i=0; i < selArray.length; i++) {
  option += "<option value='" + selArray[i] + "'/>";
  }
  selMenu.innerHTML = option;
  //Create producers list
  option = "";
  for(i=0; i < arrProducers.length; i++) {
    option += "<option value='" + arrProducers[i] + "'/>";
  }
  document.getElementById("inp_producer").innerHTML = option;

  document.getElementById("inp_parttext").value = "";
  document.getElementById("inp_parttext").focus();
}

function pressEnter(element) {
  if (event.key === "Enter") {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a keypress
    element.focus();
    element.select();
  }
}

function tableAction(element) {
  element.classList.toggle("tr_selected");
}

function tableSelectAll() {
  let table, rowscount, i, btn;
  table = document.getElementById("inp_changed");
  rowscount = table.rows.length - 1;
  btn = document.getElementById("btn_select");
  if(table_selected == "none") {
    for(i = 1; i <= rowscount; i++) {
    table.rows[i].classList.add("tr_selected");
    }
    table_selected = "all";
    btn.innerHTML = "Select none";
    } else {
      for(i = 1; i <= rowscount; i++) {
      table.rows[i].classList.remove("tr_selected");
      }
      table_selected = "none";
      btn.innerHTML = "Select all";
    }
}

function changeStatus() {
  document.getElementById("lbl_status").innerHTML = "changed";
}

function changeStatusCar() {
  document.getElementById("lbl_status_car").innerHTML = "changed";
}

function queuePart() {
  if(document.getElementById("lbl_status").innerHTML != "changed") {
    return;
  }
  if(checkVal("part") == "invalid") {
    return;
  }
  let selgroup, table, rowscount, row, cell1, cell2, cell3, cell4, cell5, cell6;
  table = document.getElementById("inp_changed");
  rowscount = table.rows.length;
  //MAX NUMBER OF PARTS IN TABLE 100
  if(rowscount == 101) {
    customAlert("alert", "Maximum number of changed parts in service is 100!");
    return;
  }
  row = table.insertRow(rowscount);
  cell1 = row.insertCell(0);
  cell2 = row.insertCell(1);
  cell3 = row.insertCell(2);
  cell4 = row.insertCell(3);
  cell5 = row.insertCell(4);
  cell6 = row.insertCell(5);
  cell7 = row.insertCell(6);

  selgroup = document.getElementById("inp_group");

  cell1.innerHTML = onlyAN(document.getElementById("inp_parttext").value);
  cell2.innerHTML = onlyAN(document.getElementById("inp_type").value);
  cell3.innerHTML = selgroup.options[selgroup.selectedIndex].text;
  cell4.innerHTML = onlyAN(document.getElementById("inp_prodtext").value);
  cell5.innerHTML = onlyAN(document.getElementById("inp_price").value);
  cell6.innerHTML = onlyAN(document.getElementById("inp_note").value);
  cell7.innerHTML = selgroup.value;
  cell7.style = "display:none";
  //Set attribute onclick for highlighting the row
  row = table.rows[rowscount];
  row.setAttribute("onclick","tableAction(this);");
  //Reset input fields
  document.getElementById("inp_parttext").value ="";
  document.getElementById("inp_type").value = "";
  document.getElementById("inp_prodtext").value = "";
  document.getElementById("inp_price").value = "0";
  document.getElementById("inp_note").value = "";
  //Reset changed status
  document.getElementById("lbl_status").innerHTML = "none";
  document.getElementById("inp_parttext").focus();
  //Unred table (div table-container)
  document.getElementById("table-container").style = "width:90%;height:160px;overflow:auto;border:3px solid grey;border-radius:4px;";
}

function resetInput() {
  let inpDate, inpKm, inpSPrice, inpPart, inpType, inpProducer, inpPrice, inpNote;
  let inpManufacturer, inpModel, inpAdditional, inpYear, inpCcm, inpPower;
  let inpTable, rowscount, row, i;
  inpDate = document.getElementById("inp_date");
  inpKm = document.getElementById("inp_km");
  inpSPrice = document.getElementById("inp_svcprice");
  inpPart = document.getElementById("inp_parttext");
  inpType = document.getElementById("inp_type");
  inpProducer = document.getElementById("inp_prodtext");
  inpPrice = document.getElementById("inp_price");
  inpNote = document.getElementById("inp_note");
  inpTable = document.getElementById("inp_changed");

  inpManufacturer = document.getElementById("inp_manufacturer");
  inpModel = document.getElementById("inp_model");
  inpAdditional = document.getElementById("inp_additional");
  inpYear = document.getElementById("inp_year");
  inpCcm = document.getElementById("inp_ccm");
  inpPower = document.getElementById("inp_power");

  //Reset input fields
  unRed(inpDate);
  inpKm.value = "";
  unRed(inpKm);
  document.getElementById("inp_service").selectedIndex = 0;
  inpSPrice.value = "0";
  unRed(inpSPrice);
  document.getElementById("inp_group").selectedIndex = 0;
  inpPart.value = "";
  unRed(inpPart, false);
  inpType.value = "";
  inpProducer.value = "";
  inpPrice.value = "0";
  unRed(inpPrice, false);
  inpNote.value = "";

  inpManufacturer.selectedIndex = 0;
  unRed(inpModel, false);
  inpModel.value = "";
  inpAdditional.value = "";
  inpYear.value = "";
  inpCcm.value = "";
  inpPower.value = "";


  //Reset table
  rowscount = inpTable.rows.length - 1;
  for(i = 0; i < rowscount; i++) {
      inpTable.deleteRow(rowscount - i);
  }

  //Reset changed status
  document.getElementById("lbl_status").innerHTML = "none";
  document.getElementById("lbl_status_car").innerHTML = "none";
  //Unred table (div table-container)
  document.getElementById("table-container").style = "width:90%;height:160px;overflow:auto;border:3px solid grey;border-radius:4px;";
}

function unqueuePart() {
  let table, rowscount, row, i;
  table = document.getElementById("inp_changed");
  rowscount = table.rows.length - 1;
  i = 0;
  while(rowscount > 0) {
    row = table.rows[i];
    if(row.classList.contains("tr_selected")) {
      table.deleteRow(i);
      i = 0;
    }
    i++;
  }
}

function addService() {
    const httpc = new XMLHttpRequest();
    let url = "addservice.php";
    let sel_car, iKm, iDate, iType, iSvcPrice; //input values

    //If inputs not valid exit function
    if (checkVal('service') != "valid") { return; }

    sel_car = document.getElementById("i_cars").value; //Selected car (database name)
    iKm = onlyAN(document.getElementById("inp_km").value);
    iDate = document.getElementById("inp_date").value;
    iDate = iDate.replace(/-/g, "");
    iType = document.getElementById("inp_service").value;
    iSvcPrice = onlyAN(document.getElementById("inp_svcprice").value);
    const data = {val_km: iKm, val_date: iDate, val_type: iType, val_car: sel_car, svc_price: iSvcPrice};
    const jObj = JSON.stringify(data);
    httpc.open("POST", url, true);

    httpc.onreadystatechange = function() { //Call a function when the state changes.
        if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
            insertParts();
        }
      };
    httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpc.send("x=" + jObj);
}

function addCar() {
    const httpc = new XMLHttpRequest();
    let sel, sel_length, i, dbname, input_db, match_count = 0;
    let url = "addcar.php";
    let iManufacturer, iModel, iAdditional, iYear, iCcm, iPower; //input values

    //If inputs not valid exit function
    if (checkValCar() != "valid") { return; }

    iManufacturer = document.getElementById("inp_manufacturer");
    if (iManufacturer.value == "other") {
      iManufacturer = onlyAN(document.getElementById("inp_other").value);
    } else {
      iManufacturer = iManufacturer.options[iManufacturer.selectedIndex].textContent;
    }
    iModel = onlyAN(document.getElementById("inp_model").value);
    iAdditional = onlyAN(document.getElementById("inp_additional").value);
    iYear = onlyAN(document.getElementById("inp_year").value);
    iCcm = onlyAN(document.getElementById("inp_ccm").value);
    iPower = onlyAN(document.getElementById("inp_power").value);
    //If car already exists create new car with different database name
    sel = document.getElementById("i_cars");
    sel_length = sel.length;
    input_db = iManufacturer.replace(/ /g, "").toLowerCase();
    input_db = input_db + "_" + iModel.replace(/ /g, "").toLowerCase();
    for (i=1; i < sel_length; i++) {
      dbname = sel.options[i].value.replace("i_", "");

      if (dbname.search(input_db) >= 0) {
        match_count = match_count + 1;
      }
    }

    if (match_count == 0) {
      match_count = "";
    }
    const data = {val_mfc: iManufacturer, val_model: iModel, val_add: iAdditional, val_year: iYear,
      val_ccm: iCcm, val_power: iPower, match: match_count};
    const jObj = JSON.stringify(data);
    httpc.open("POST", url, true);

    httpc.onreadystatechange = function() { //Call a function when the state changes.
        if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
            //SUCCESS MESSAGE
            document.getElementById("btn_ok").setAttribute("onclick", "alertOK()");
            customAlert("info", "Car added successfully: " + iManufacturer + " " + iModel);
        }
      };
    httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpc.send("x=" + jObj);
    closeModal();
}

function insertParts() {
    let xhr = [], i, jObj, table, rowscount, iTableName;
    let objPart = {name:"", type:"", group:"", producer:"", price:"", note:"", car:"", tablename:"", grouptext:""};
    let objTable = {dbname:"", name:""};
    let sel_car, iKm, iDate, iType, iSvcPrice; //input values
    let edit = document.getElementById("lbl_edit").innerHTML;
    const httpc = new XMLHttpRequest();

    table = document.getElementById("inp_changed");
    rowscount = table.rows.length - 1;
    iKm = document.getElementById("inp_km").value;
    iDate = document.getElementById("inp_date").value;
    iDate = iDate.replace(/-/g, "");
    iType = document.getElementById("inp_service").value;
    iSvcPrice = document.getElementById("inp_svcprice").value;
    iTableName = iKm + "_" + iType + "_" + iDate + "_" + iSvcPrice;

    // If edit mode then use emptytable.php to clear the database table (service)
    // and isert parts all over again
    if (edit == "yes") {
      objTable.dbname = global_car;
      objTable.name = iTableName;
      jObj = JSON.stringify(objTable);
      httpc.open("POST", "emptytable.php", false);
      httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      httpc.send("x=" + jObj);
    }

    for(i = 1; i <= rowscount; i++){ //for loop
      (function(i){
        objPart.name = table.rows[i].cells[0].innerHTML;
        objPart.type = table.rows[i].cells[1].innerHTML;
        objPart.group = table.rows[i].cells[6].innerHTML; //hidden <td>
        objPart.producer = table.rows[i].cells[3].innerHTML;
        objPart.price = table.rows[i].cells[4].innerHTML;
        objPart.note = table.rows[i].cells[5].innerHTML;
        objPart.car = global_car;
        objPart.tablename = iTableName;
        objPart.grouptext = table.rows[i].cells[2].innerHTML;
        jObj = JSON.stringify(objPart);
        xhr[i] = new XMLHttpRequest();
        xhr[i].open("POST", "addpart.php", false);

        //Info message on succes and reload page (accordions)
        xhr[i].onreadystatechange = function() { //Call a function when the state changes.
        if(xhr[i].readyState == 4 && xhr[i].status == 200) { // complete and no errors
            customAlert("info", "Service saved successfully.");
        }
      };
      xhr[i].setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr[i].send("x=" + jObj);
    })(i);
  }
  closeModal();
}

function customAlert(type="info", message="", callback) {
  //type = info / confirm / alert
  let alertContent = document.getElementById("alert_content");
  let alertTitle = document.getElementById("alert_title");
  document.getElementById("custom_alert").style.display = "block";
  document.getElementById("body1").style.overflow = "hidden";
  document.getElementById("alert_msg").innerHTML = message;

  if (type == "info") {
    document.getElementById("btn_yes").style.visibility = "hidden";
    document.getElementById("btn_no").style.visibility = "hidden";
    document.getElementById("btn_ok").style.visibility = "visible";
    document.getElementById("btn_ok").focus();
    alertContent.style = "box-shadow: 0 0 5px 5px rgba(0, 102, 255, 0.3)";
    alertTitle.innerHTML = "<b>INFO</b>";
  } else if (type == "alert") {
    document.getElementById("btn_yes").style.visibility = "hidden";
    document.getElementById("btn_no").style.visibility = "hidden";
    document.getElementById("btn_ok").style.visibility = "visible";
    document.getElementById("btn_ok").focus();
    alertContent.style = "box-shadow: 0 0 5px 5px rgba(255, 0, 0, 0.3)";
    alertTitle.innerHTML = "<b>ERROR</b>";
  } else {
    document.getElementById("btn_yes").style.visibility = "visible";
    document.getElementById("btn_no").style.visibility = "visible";
    document.getElementById("btn_ok").style.visibility = "hidden";
    alertContent.style = "box-shadow: 0 0 5px 5px rgba(0, 102, 255, 0.3)";
    alertTitle.innerHTML = "<b>CONFIRM</b>";
  }
  //Top position - IMPROVE THIS
  alertContent.style.top = (window.innerHeight / 2 - 200) + "px";
}

function closeAlert() {
  document.getElementById('custom_alert').style.display='none';
  document.getElementById('body1').style.overflow = 'visible';
}

function checkVal(type) {
let inpDate, inpKm, inpSType, inpSPrice, inpName, inpPrice, inpTable, rowscount, tableContainer;
let checkStatus = "valid";
let alertMsg = "You entered incorrectly this data:<br><br>";
let redInput = "border-color:#ff4d4d;background-color:#ffe6e6;box-shadow:0 0 4px 4px #ff9999";
  inpDate = document.getElementById("inp_date");
  inpKm = document.getElementById("inp_km");
  inpSType = document.getElementById("inp_service");
  inpSPrice = document.getElementById("inp_svcprice");
  inpName = document.getElementById("inp_parttext");
  inpPrice = document.getElementById("inp_price");
  tableContainer = document.getElementById("table-container");
  inpTable = document.getElementById("inp_changed");
  rowscount = inpTable.rows.length;
  switch(type) {
  case "service":
  //Date
  if(inpDate.value == "") {
    inpDate.style = redInput;
    checkStatus = "invalid";
    alertMsg = alertMsg + "- Date (you have to choose a valid date)<br>";
  }
  //Kilometers
  if(isNaN(inpKm.value) == true || inpKm.value == "") {
    inpKm.style = redInput;
    checkStatus = "invalid";
    alertMsg = alertMsg + "- Mileage (you have to enter valid mileage, bigger then 0)<br>";
  } else if(Number.isInteger(Number(inpKm.value)) == false || Number(inpKm.value) <= 0) {
      inpKm.style = redInput;
      checkStatus = "invalid";
      alertMsg = alertMsg + "- Mileage (you have to enter valid mileage, bigger then 0)<br>";
  }
  //Service price
  if(isNaN(inpSPrice.value) == true || inpSPrice.value == "") {
    inpSPrice.style = redInput;
    checkStatus = "invalid";
    alertMsg = alertMsg + "- Service price (you have to enter valid price, only 'zero' or bigger number)<br>";
  } else if(Number.isInteger(Number(inpSPrice.value)) == false || Number(inpSPrice.value) < 0) {
      inpSPrice.style = redInput;
      checkStatus = "invalid";
      alertMsg = alertMsg + "- Service price (you have to enter valid price, only 'zero' or bigger number)<br>";
  }
  //Empty parts table
  if(rowscount < 2) {
    tableContainer. style = "width:90%;height:160px;overflow:auto;border:3px solid #ff4d4d;border-radius:4px;box-shadow:0 0 4px 4px #ff9999";
    checkStatus = "invalid";
    alertMsg = "You haven't added any part!";
  }
  break;

  case "part":
  //Part name
  if(inpName.value.length < 1) {
    inpName.style = redInput;
    checkStatus = "invalid";
    alertMsg = alertMsg + "- Part name (you have to enter part name)<br>";
  }
  //Part price
  if(isNaN(inpPrice.value) == true || inpPrice.value == "") {
    inpPrice.style = redInput;
    checkStatus = "invalid";
    alertMsg = alertMsg + "- Part price (you have to enter valid price, only 'zero' or bigger number)<br>";
  } else if(Number.isInteger(Number(inpPrice.value)) == false || Number(inpPrice.value) < 0) {
      inpPrice.style = redInput;
      checkStatus = "invalid";
      alertMsg = alertMsg + "- Part price (you have to enter valid price, only 'zero' or bigger number)<br>";
  }
  break;
}
if(checkStatus == "invalid") {
customAlert("alert", alertMsg);
}
return checkStatus;
}

function checkValCar() {
let inpManufacturer = document.getElementById("inp_manufacturer");
let inpModel = document.getElementById("inp_model");
let inpOther = document.getElementById("inp_other");
let checkStatus = "valid", alertMsg;
let redInput = "border-color:#ff4d4d;background-color:#ffe6e6;box-shadow:0 0 4px 4px #ff9999";
if (inpModel.value.length < 1) {
  alertMsg = "You have to enter car model!";
  inpModel.style = redInput;
  checkStatus = "invalid";
  customAlert("alert", alertMsg);
}
if (inpManufacturer.value == "") {
  alertMsg = "You have to choose car manufacturer!";
  inpManufacturer.style = redInput;
  checkStatus = "invalid";
  customAlert("alert", alertMsg);
} else if (inpManufacturer.value == "other" && inpOther.value.length < 1) {
  alertMsg = "You have to enter car manufacturer!";
  inpPos = inpOther.style.position;
  inpLeft = inpOther.style.left;
  inpTop = inpOther.style.top;
  posStyle = "position:" + inpPos + ";left:" + inpLeft + ";top:" + inpTop;
  inpOther.style = posStyle + ";" + redInput;
  checkStatus = "invalid";
  customAlert("alert", alertMsg);
}
return checkStatus;
}

//Reset invalid (red) input fields
function unRed(element, service = true) {
  if(service == true) {
  element.style = "background-color:#e0ebeb";
  } else if (element.id == "inp_other") {
      inpPos = element.style.position;
      inpLeft = element.style.left;
      inpTop = element.style.top;
      posStyle = "position:" + inpPos + ";left:" + inpLeft + ";top:" + inpTop;
      element.style = posStyle;
  } else {
    element.style = "";
  }
}

function newCar() {
  //Set default position for inp_other (behind select inp_manufacturer)
  let txtElmnt = document.getElementById("inp_other");
  let selElmnt = document.getElementById("inp_manufacturer")
  let rect = selElmnt.getBoundingClientRect();
  txtElmnt.style.position = "absolute";
  txtElmnt.style.top = rect.top + "px";
  txtElmnt.style.left = rect.left + "px";

  document.getElementById("div_car").style.display = "block";
  document.getElementById("body1").style.overflow = "hidden";
}

function showOther(show) {
  //show = true or false
  let txtElmnt = document.getElementById("inp_other");
  let selElmnt = document.getElementById("inp_manufacturer")
  let rect = selElmnt.getBoundingClientRect();
  txtElmnt.style.position = "absolute";
  txtElmnt.style.top = rect.top + "px";
  txtElmnt.style.left = rect.left + "px";
  switch (show) {
  case true:
  if (selElmnt.value == "other") {
  selElmnt.style.visibility = "hidden";
  txtElmnt.style.visibility = "visible";
  txtElmnt.style.display = "inline";
  txtElmnt.focus();
  }
  break;
  case false:
  selElmnt.style.visibility = "visible";
  txtElmnt.style.visibility = "hidden";
  txtElmnt.style.display = "none";
  selElmnt.focus();
}
}

function alertOK() {
  let selcar;
  selcar = document.getElementById("i_cars");
  window.localStorage.setItem("ic_selcar", selcar.length);
  location.replace(location.href);
}

function deleteService(msg_data) {
  if (msg_data == null || msg_data == "delete_car") {
    return;
  }

  const httpc = new XMLHttpRequest();
  let spanarr, svcDatabase, svcTable;
  let url = "delservice.php"

  spanarr = msg_data.split("//");
  svcDatabase = spanarr[0];
  svcTable = spanarr[1];
  const data = {val_dbname: svcDatabase, val_table: svcTable};
  const jObj = JSON.stringify(data);
  httpc.open("POST", url, true);

  httpc.onreadystatechange = function() { //Call a function when the state changes.
      if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
         customAlert("info", "Service deleted successfully.");
        }
    };
  httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  httpc.send("x=" + jObj);
}

function deleteCar() {
  if (delete_data != "delete_car") {
    return;
  }

  const httpc = new XMLHttpRequest();
  let dbname = document.getElementById("i_cars").value;
  let url = "delcar.php"

  httpc.open("POST", url, true);

  httpc.onreadystatechange = function() { //Call a function when the state changes.
      if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
         window.localStorage.setItem("ic_selcar", 1);
         customAlert("info", "Car deleted successfully.");
        }
    };
  httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  httpc.send("x=" + dbname);
}

function sendDeleteCar() {
  let sel_cars = document.getElementById("i_cars").selectedIndex;
  if (sel_cars <= 0) {
    customAlert("alert", "Choose a car!");
    return;
  }
  customAlert("confirm", "<i class='fas fa-exclamation-triangle' style='font-size:1.8vw;color:red'></i>&nbsp&nbsp"
     + "Are you sure you want to delete the car?<br><br>All car data will be deleted!");
  delete_data = "delete_car";
}

function openCarInfo() {
  let sel_cars = document.getElementById("i_cars").selectedIndex;
  let div = document.getElementById("div_car");
  let carinfo;
  let header = document.getElementById("car_header");
  let model = document.getElementById("inp_model");
  let manufacturer = document.getElementById("inp_manufacturer");
  let add = document.getElementById("inp_additional");
  let year = document.getElementById("inp_year");
  let ccm = document.getElementById("inp_ccm");
  let power = document.getElementById("inp_power");
  let btn_ok = document.getElementById("btn_savecar");

  const httpc = new XMLHttpRequest();
  let cardb = document.getElementById("i_cars").value;
  let url = "carinfo.php"

  if (sel_cars <= 0) {
    customAlert("alert", "Choose a car!");
    return;
  }

  const data = {val_dbname: cardb};
  const jObj = JSON.stringify(data);
  httpc.open("POST", url, true);

  httpc.onreadystatechange = function() { //Call a function when the state changes.
      if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
         carinfo = this.responseText;
         cararr = carinfo.split("//");
         header.innerHTML = "<i class='fas fa-car'></i>&nbsp&nbspCar info";
         manufacturer.value = cararr[1];
         manufacturer.disabled = true;
         model.value = cararr[0];
         model.disabled = true;
         add.value = cararr[2];
         add.disabled = true;
         year.value = cararr[3];
         year.disabled = true;
         ccm.value = cararr[4];
         ccm.disabled = true;
         power.value = cararr[5];
         power.disabled = true;
         btn_ok.innerHTML = "OK";
         btn_ok.setAttribute("onclick", "closeNewCar()");

         div.style.display = "block";
         document.getElementById("body1").style.overflow = "hidden";
        }
    };
  httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  httpc.send("x=" + jObj);
}

function editService(msg_data) {
  if (msg_data == null) {
    return;
  }
  let i, table, rowscount, row, cell1, cell2, cell3, cell4, cell5, cell6, svc_arr, date;
  let carname = document.getElementsByClassName('select-selected')[0].innerHTML;

  global_car = document.getElementById("i_cars").value; // used in InsertParts()
  
  const httpc = new XMLHttpRequest();
  let spanarr, svcDatabase, svcTable, tbl_data, data_arr, tbl_row;
  let url = "editservice.php"

  spanarr = msg_data.split("//");
  svcDatabase = spanarr[0];
  svcTable = spanarr[1];

  //Insert service data into input fields and disable them
  svc_arr = svcTable.split("_");
  date = svc_arr[2].slice(0, 4);
  date += "-" + svc_arr[2].slice(4, 6);
  date += "-" + svc_arr[2].slice(6, 8);
  document.getElementById("inp_date").value = date;
  document.getElementById("inp_km").value = svc_arr[0];
  document.getElementById("inp_service").value = svc_arr[1];
  document.getElementById("inp_svcprice").value = svc_arr[3];
  document.getElementById("inp_date").disabled = true;
  document.getElementById("inp_km").disabled = true;
  document.getElementById("inp_service").disabled = true;
  document.getElementById("inp_svcprice").disabled = true;
  document.getElementById("lbl_status").innerHTML = "none";

  const data = {val_dbname: svcDatabase, val_table: svcTable};
  const jObj = JSON.stringify(data);
  httpc.open("POST", url, true);

  httpc.onreadystatechange = function() { //Call a function when the state changes.
  if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
  tbl_data = this.responseText;
  data_arr = tbl_data.split("\n");
  rowscount = data_arr[0];
  table = document.getElementById("inp_changed");

  for (i = 1; i <= rowscount; i++) {
  tbl_row = data_arr[i];
  row_arr = tbl_row.split("//");

  row = table.insertRow(i);
  cell1 = row.insertCell(0);
  cell2 = row.insertCell(1);
  cell3 = row.insertCell(2);
  cell4 = row.insertCell(3);
  cell5 = row.insertCell(4);
  cell6 = row.insertCell(5);
  cell7 = row.insertCell(6);

  cell1.innerHTML = row_arr[0];
  cell2.innerHTML = row_arr[1];
  cell3.innerHTML = row_arr[6];
  cell4.innerHTML = row_arr[2];
  cell5.innerHTML = row_arr[3];
  cell6.innerHTML = row_arr[4];
  cell7.innerHTML = row_arr[5];
  cell7.style = "display:none";
  //Set attribute onclick for highlighting the row
  row = table.rows[i];
  row.setAttribute("onclick","tableAction(this);");
  } //end for loop
      }
    };
  httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  httpc.send("x=" + jObj);

  document.getElementById("div_modal").style.display = "block";
  document.getElementById("lbl_edit").innerHTML = "yes";
  document.getElementById("svc_header").innerHTML = "<b><i class='fas fa-wrench'></i>&nbsp&nbspEdit service for&nbsp<span id='selcar'></span></b>";
  document.getElementById("selcar").innerHTML = carname;
  document.getElementById("body1").style.overflow = "hidden";
}

//Only alphanumeric unicode, no other characters
function onlyAN(input) {
  if (input == "") {
    return "";
  }

  return input.match(/[\p{L}\p{N}\s \.\-]/gu).join("");
}