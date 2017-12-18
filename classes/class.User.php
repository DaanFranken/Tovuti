<?php
	class User
	{
		private $_db;
		private $id;
		private $username;
		private $firstname;
		private $lastname;
		private $password;
		private $email;

		// Db connection
		$db = new Database();
		$this->_db = $db->getDB();

		// Login check
		public function loginCheck()
		{
			if(isset($_SESSION['user_ID']) AND isset($_SESSION['Username']) AND isset($_SESSION['Password']))
			{
				$sth = $this->_db->selectDatabase($db, 'users', 'user_ID', $_SESSION['user_ID'], ' AND Username = '.$_SESSION['Username'].' AND Password = '.$_SESSION['Password']);
				if($sth->fetch())
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		// Login user
		public function login($username, $password)
		{
			$sth = $this->_db->selectDatabase($db, 'users', 'Username', $username);
			if($row = $sth->fetch())
			{
				if(password_verify($password))
				{
					$_SESSION['user_ID'] = $row['user_ID'];
					$_SESSION['Username'] = $row['Username'];
					$_SESSION['Password'] = $row['Password'];
					echo 'You have successfully logged in';
					return true;
				}
				else
				{
					echo 'Your username and/or password is incorrect';
					return false;
				}
			}
			else
			{
				echo 'Your username and/or password is incorrect';
				return false;
			}
		}

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
					$arrayValues['Password'] = password_hash($password);
					$arrayValues['Email'] = $email;
					insertDatabase($db, $tableName, $arrayValues);
					echo 'Your account has been successfully registered';
				}
			}
		}
	}
?>