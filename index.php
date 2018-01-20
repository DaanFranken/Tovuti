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
<div id="mainMenu">
	<?php
	$uri = str_replace('/Tovuti/', '', $_SERVER['REQUEST_URI']);
	$uri = rtrim($uri, '/');
	if(strpos($uri, '?'))
	{
		$uri = substr($uri, 0, strpos($uri, '?'));
	}
	// if(!array_key_exists($uri, $misc->routes)) {
	// 	$uri = '';
	// }
// echo '<script>alert("'.$uri.'");</script>';
	include 'menu.php';
	?>
</div>
<div id="mainContainer">
	<?php
	switch($uri)
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
		case 'portfolio':
			include 'portfolio.php';
			break;
		default:
			include 'home.php';
	}

	$username = $misc->readVar('POST','username');

	?>
</div>
</body>
</html>