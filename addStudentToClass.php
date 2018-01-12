<?php
session_start();
include 'classes/class.Database.php';
$db = new Database();

$sth = $db->selectDatabase('students', 'class_ID', '0', '');
while($row = $sth->fetch())
{
	$sth2 = $db->selectDatabase('users', 'user_ID', $row['user_ID'], '');
	$row2 = $sth2->fetch();
	echo '<option value="'.$row['user_ID'].'">'.$row2['Firstname'].' '.$row2['Lastname'].'</option>';
}