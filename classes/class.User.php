<?php

	class User
	{
		private $db;
		private $id;
		private $username;
		private $firstname;
		private $lastname;
		private $password;
		private $email;

		// Login check
		// function __construct()
		// {

		// }

		public function register($username, $firstname, $lastname, $password, $retypePass, $email)
		{
			// Register account
			if(isset($_POST['register']))
			{
				$errorCheck = true;

				// Check username
				if(strlen($_POST['username']) < 6)
				{
					echo 'Your username must be atleast 6 characters';
					$errorCheck = false;
				}

				// Check email
				if(!empty($_POST['email']))
				{
					if(strlen($_POST['email']) < 10)
					{
						echo 'Your email is incorrect';
						$errorCheck = false;
					}
				}

				// Check password
				if($password != $retypePass)
				{
					echo 'Your passwords do not match';
					$errorCheck = false;
				}

				if($errorCheck)
				{
					$arrayValues['Firstname'] = $firstname;
					$arrayValues['Lastname'] = $lastname;
					// $arrayValues['Password'] = password_hash();
					$arrayValues['Email'] = $email;
					insertDatabase($db, $tableName, $arrayValues);
				}
			}
		}
	}
?>