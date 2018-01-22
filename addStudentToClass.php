<?php
session_start();
include_once 'autoloader.php';
$db = new Database();
$user = new User();

$user->loginCheck();
if($user->permission == 2)
{
	$sth = $db->selectDatabase('teachers', 'user_ID', $user->id, '');
	if($row = $sth->fetch())
	{
		$sth = $db->selectDatabase('students', 'class_ID', '', '');
		while($row = $sth->fetch())
		{
			$sth2 = $db->selectDatabase('users', 'user_ID', $row['user_ID'], '');
			$row2 = $sth2->fetch();
			echo '<option value="'.$row['user_ID'].'">'.$row2['Firstname'].' '.$row2['Lastname'].'</option>';
		}
	}
}