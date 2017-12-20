<?php
	class User
	{
		protected $db;
		private $id;
		private $username;
		private $firstname;
		private $lastname;
		private $password;
		private $email;
		private $permission;

		// Db connection
		public function __construct($username = NULL)
		{
			$this->db = new Database();
			if(!empty($username))
			{
				$sth = $this->db->selectDatabase('users', 'Username', $username, '');
				if($row = $sth->fetch())
				{
					$this->id 			= $row['user_ID'];
					$this->username 	= $row['Username'];
					$this->firstname 	= $row['Firstname'];
					$this->lastname 	= $row['Lastname'];
					$this->password 	= $row['Password'];
					$this->email 		= $row['Email'];
					$this->permission	= $row['Permission'];	
					return true;
				}
			}
		}

		// Login check
		public function loginCheck()
		{
			if(isset($_SESSION['user_ID']) AND isset($_SESSION['Username']) AND isset($_SESSION['Password']))
			{
				$sth = $this->db->selectDatabase('users', 'user_ID', $_SESSION['user_ID'], ' AND Username = "'.$_SESSION['Username'].'" AND Password = "'.$_SESSION['Password'].'"');
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
			$sth = $this->db->selectDatabase('users', 'Username', $username, '');
			if($row = $sth->fetch())
			{
				if(password_verify($password, $row['Password']))
				{
					// Session variables
					$_SESSION['user_ID'] = $row['user_ID'];
					$_SESSION['Username'] = $row['Username'];
					$_SESSION['Password'] = $row['Password'];

					// Object variables
					$this->id 			= $row['user_ID'];
					$this->username 	= $row['Username'];
					$this->firstname 	= $row['Firstname'];
					$this->lastname 	= $row['Lastname'];
					$this->password 	= $row['Password'];
					$this->email 		= $row['Email'];
					$this->permission	= $row['Permission'];
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
			if(!isset($_POST['register']))
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
					$arrayValues['Password'] = password_hash($password, PASSWORD_DEFAULT);
					$arrayValues['Email'] = $email;
					$this->db->insertDatabase('users', $arrayValues);
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