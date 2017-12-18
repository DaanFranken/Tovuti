<?php
include 'dbHelper.php';

if($DBlink = @dbconnect($host,$user,$pass,$db))
{
	// connection failed
}
else
{
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'tovuti';
	if($DBlink = dbconnect($host,$user,$pass,$db))
	{
		// Connected
	}
	else
	{
		// connection failed
	}
	$conn = new mysqli($host, $user, $pass, $db);
}
?>