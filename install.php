<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Car Service E-book - Installation</title>
<style>
body {
	font-family: Arial, sans-serif;
	font-size: 1.5vw;
	color: #00264d;
}
.div_main {
	display: block;
	padding: 20px;
	border: 2px solid grey;
	border-radius: 5px;
	background-color: #f2f2f2;
	height: 40vw;
	width: 90%;
	margin: auto;
	overflow: hidden;
}
.div_content {
	display: flex;
	margin: auto;
	width: auto;
}
.button_blue {
	background-color: #b3b3b3;
	border-color: rgb(0, 102, 255);
	border-radius: 0.1em;
	color: blue;
	font-size: 1.2em;
	padding: 0.4em 0.9em;
}
.button_blue:hover {
	background-color: #bfbfbf;
	cursor: pointer;
}
.custom-alert {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	z-index: 2;
	width: 100%;
	height: 100%;
	background-color: rgba(0,0,0,0.4);
}

.alert-header {
	width: 100%;
	height: 40px;
	padding-top: 4px;
	border-bottom: 2px solid #94b8b8;
}

.alert-content {
	position: relative;
	background-color: #ccc;
	color: #00264d;
	box-shadow: 0 0 5px 5px rgba(0, 102, 255, 0.3);
	width: 35%;
	height: 250px;
	margin: auto;
}

.alert-body {
	width: 100%;
	height: 50%;
	padding-left: 10px;
	padding-right: 10px;
}

.alert-footer {
	width: 100%;
	margin-left: 36%;
}
</style>
<script>
let success;

function install() {
  const httpc = new XMLHttpRequest();
  let url = "req_install.php"
  let response;

  httpc.open("POST", url, true);

  httpc.onreadystatechange = function() { //Call a function when the state changes.
      if(httpc.readyState == 4 && httpc.status == 200) { // complete and no errors
      	response = this.responseText;
      	response_arr = response.split("//");
      	success = response_arr[0];
        customAlert(response_arr[1]);
        }
    };
  httpc.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  httpc.send();
}

function customAlert(amsg = "") {
	if (amsg == "") {
		amsg = "Installed successfully.<br>Enjoy the app.";
	}
	alertContent = document.getElementById("alert_content");
	alertMsg = document.getElementById("alert_msg");
	document.getElementById("custom_alert").style.display = "block";

	alertMsg.innerHTML = amsg;
	alertContent.style.top = (window.innerHeight / 2 - 250) + "px";
}

function closeAlert() {
	document.getElementById("custom_alert").style.display = "none";
	if (success == "success") {
	location.replace("index.php");
	}
}
</script>
</head>

<body>
<div class="div_main">
<div class="div_content">
<div style="width:auto;margin:auto;text-align:center;">
	<h1>Car Service E-book</h1>
	<h3>Installation</h3>
	<h5>Welcome to Car Service E-book installation.<br>Click the button below to start the installation.</h5>
	<button class="button_blue" onclick="install()">Install</button>
</div>
</div>
</div>

<div id="custom_alert" class="custom-alert">
<div id="alert_content" class="alert-content">
	<div class="alert-header">
	<span id="alert_title" style="float:left;padding-top:5px;padding-left:10px;"><b>INFO</b></span>
	</div>
	<div class="alert-body">
	<p id="alert_msg" style="padding-left:10%;">
    </p>
    </div>
	<div class="alert-footer">
	<button id="btn_ok" class="button_blue" style="width:28%;font-size:1em;padding:0.2em 0.5em;" onclick="closeAlert()">OK</button>
	</div>
</div>
</div>
</body>
</html>