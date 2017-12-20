<?php
session_start();
include_once 'autoloader.php';
$db = new Database();
$misc = new Misc();
$user = new User();
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="style/index.css">
<link rel="stylesheet" href="style/menu.css">
</head>
<body>
<div id="mainMenu">
	<div id="mainMenuFullscreen">
		<a href="index.php">
			<img src="images/deZevensprong.png" alt="de Zevensprong" style="width: 100%;height: 100%;">
		</a>
		<div class="mainMenuLink">
			Home
		</div>
	</div>
	<div id="mainMenuWindowed">

	</div>
</div>
<div id="mainContainer">
<?php

if($misc->readVar('GET', 'pageStr'))
{
	$pageStr = $_GET['pageStr'];
}
else
{
	$pageStr = 'home';
}
switch($pageStr)
{
	case 'home':
		include 'home.php';
		break;
	case 'login':
		include 'login.php';
		break;
	case 'register':
		include 'register.php';
		break;
	default:
		include 'home.php';
}

$username = $misc->readVar('POST','username');

?>
</div>
</body>
</html>