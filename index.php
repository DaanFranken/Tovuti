<?php
session_start();
include_once 'autoloader.php';
$db = new Database();
$misc = new Misc();
$user = new User();
$thread = new Thread();

$user->loginCheck();
?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="style/index.css">
<link rel="stylesheet" href="style/menu.css">
<script src="https://use.fontawesome.com/1ae0501f24.js"></script>
</head>
<body>
	<?php

	if($misc->readVar('GET', 'pageStr'))
	{
		$pageStr = $_GET['pageStr'];
	}
	else
	{
		$pageStr = 'home';
	}

	?>
<div id="mainMenu">
	<?php
	include 'menu.php';
	?>
</div>
<div id="mainContainer">
	<?php

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
		case 'account':
			include 'account.php';
			break;
		case 'accountConfirm':
			include 'accConfirm.php';
			break;
		case 'passwordConfirm':
			include 'passConfirm.php';
			break;
		case 'forum':
			include 'thread.php';
			break;
		case 'class':
			include 'classlist.php';
			break;
		case 'activities':
			include 'activities.php';
			break;
		default:
			include 'home.php';
	}

	$username = $misc->readVar('POST','username');

	?>
</div>
</body>
</html>