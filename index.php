<?php
	session_start();
    include_once 'classes/class.Database.php';
    include_once 'classes/class.Misc.php';
    include_once 'classes/class.User.php';
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
		<form method="POST">
			<input type="text" name="username">
			<input type="text" name="password">
			<input type="submit" name="sendform">
		</form>
	</div>
</div>

</body>
</html>

<?php

if($misc->readVar('GET', 'pageStr'))
{
	$pageStr = $_GET['pageStr'];
}
else
{
	$pageStr = 1;
}
switch($pageStr)
{
	case '1':
		include 'home.php';
		break;
	// case '2':
	// 	include '';
	// 	break;
	default:
		include 'home.php';
}

$username = $misc->readVar('POST','username');
var_dump($username);

?>