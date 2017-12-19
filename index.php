<?php
	session_start();
	include_once 'autoloader.php';
	$db = new Database();
	$misc = new Misc();
	$user = new User();
    
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
</head>

<body>
<div class="w3-row">
	<div class="w3-col w3-third w3-green">
		
	</div>
</div>

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
	default:
		include 'home.php';
}

$username = $misc->readVar('POST','username');

?>

</body>
</html>