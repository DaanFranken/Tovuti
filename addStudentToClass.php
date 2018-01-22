<?php
session_start();
include_once 'autoloader.php';
$db = new Database();
$user = new User();

$user->loginCheck();
if($user->permission > 1)
{
	$sth = $this->db->selectDatabase('teachers', 'user_ID', $user->id, 'AND class_ID = "'.$_GET['class_id'].'"');
	if($sth->fetch())
	{
		$sth = $db->selectDatabase('teachers', 'user_ID', $user->id, '');
		if($row = $sth->fetch())
		{
			$sth = $db->selectDatabase('students', 'class_ID', '0', '');
			while($row = $sth->fetch())
			{
				$sth2 = $db->selectDatabase('users', 'user_ID', $row['user_ID'], '');
				$row2 = $sth2->fetch();
				echo '<option value="'.$row['user_ID'].'">'.$row2['Firstname'].' '.$row2['Lastname'].'</option>';
			}
		}
	}
}