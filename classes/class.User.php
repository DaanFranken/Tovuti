<?php

// Permissions
// 0  | No permissions
// 1  | Students
// 2  | Teachers
// 3  | Admins

class User
{
	protected $db;
	public $id;
	public $username;
	public $firstname;
	public $lastname;
	public $password;
	public $email;
	public $permission;

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

	public function getUserByID($ID)
	{
		$sth = $this->db->selectDatabase('users', 'user_ID', $ID, '');
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
		// Check if signin option was username or student number
		if(!is_numeric($username))
		{
			$sth = $this->db->selectDatabase('users', 'Username', $username, '');
			$studentNumberSignin = false;
		}
		else
		{
			$sth = $this->db->selectDatabase('students', 'studentNumber', $username, '');
			$studentNumberSignin = true;
		}

		if($row = $sth->fetch())
		{
			if($studentNumberSignin)
			{
				$sth = $this->db->selectDatabase('users', 'user_ID', $row['user_ID'], '');
				$row = $sth->fetch();
			}
			if(password_verify($password, $row['Password']))
			{
				if($row['Status'] == 1)
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
					echo 'Your account is deactivated.';
				}				
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
		if(isset($_POST['registerSubmit']))
		{
			$sth = $this->db->selectDatabase('users', 'Username', $username, '');
			if(!$row = $sth->fetch())
			{
				$errorCheck = true;

				// Check username
				if(strlen($_POST['username']) < 6)
				{
					echo 'Your username must be atleast 6 characters';
					$errorCheck = false;
				}
				if(is_numeric($_POST['username']))
				{
					echo 'Please use letters instead of numbers for your username!';
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
					$arrayValues['user_ID'] = trim(com_create_guid(), '{}');
					$arrayValues['Username'] = $username; 
					$arrayValues['Firstname'] = $firstname;
					$arrayValues['Lastname'] = $lastname;
					$arrayValues['Password'] = password_hash($password, PASSWORD_DEFAULT);
					$arrayValues['Email'] = $email;
					$arrayValues['Permission'] = 0;
					$this->db->insertDatabase('users', $arrayValues);
					echo 'Your account has been successfully registered';
				}
			}
			else
			{
				echo 'Username already exists.';
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