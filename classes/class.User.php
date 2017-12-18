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
		public function __construct()
		{
			$db = new Database();
			$this->_db = $db->getDB();
		}

		// Login check
		public function loginCheck()
		{
			$db = new Database();
			if(isset($_SESSION['user_ID']) AND isset($_SESSION['Username']) AND isset($_SESSION['Password']))
			{
				$sth = $db->selectDatabase('users', 'user_ID', $_SESSION['user_ID'], ' AND Username = "'.$_SESSION['Username'].'" AND Password = "'.$_SESSION['Password'].'"');
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
			$db = new Database();
			$sth = $db->selectDatabase('users', 'Username', $username, '');
			if($row = $sth->fetch())
			{
				if(password_verify($password, $row['Password']))
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
			$db = new Database();
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
					insertDatabase($tableName, $arrayValues);
					echo 'Your account has been successfully registered';
				}
			}
		}

		// Logout
		public function logout()
		{
			// Unset session var 
			$_SESSION = array();

			// Retrieve session parameters
			$params = session_get_cookie_params();

			// Delete session cookie
			setcookie(session_name(),
					'', time() - 42000, 
					$params["path"], 
					$params["domain"], 
					$params["secure"], 
					$params["httponly"]);

			// Destroy session
			session_destroy();
		}
	}
?>