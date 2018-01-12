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
	public function __construct($userID = NULL)
	{
		$this->db = new Database();
		if(!empty($userID) && $this->loginCheck())
		{
			$this->getUserByID($userID);
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
			$this->firstname	= $row['Firstname'];
			$this->lastname		= $row['Lastname'];
			return true;
		}
	}

	// Login check
	public function loginCheck()
	{
		if(isset($_SESSION['user_ID']) AND isset($_SESSION['Username']) AND isset($_SESSION['Password']))
		{
			$sth = $this->db->selectDatabase('users', 'user_ID', $_SESSION['user_ID'], ' AND Username = "'.$_SESSION['Username'].'" AND Password = "'.$_SESSION['Password'].'"');
			if($row = $sth->fetch())
			{
				$this->getUserByID($row['user_ID']);
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
					return true;
				}
				else
				{
					echo 'Uw account is gedeactiveerd';
				}				
			}
			else
			{
				echo 'Uw gebruikersnaam en/of wachtwoord is incorrect';
				return false;
			}
		}
		else
		{
			echo 'Uw gebruikersnaam en/of wachtwoord is incorrect';
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
					echo 'Uw gebruikersnaam moet minimaal 6 karakters bevatten<br/>';
					$errorCheck = false;
				}
				if(is_numeric($_POST['username']))
				{
					echo 'Uw gebruikersnaam moet letters bevatten<br/>';
					$errorCheck = false;
				}

				// Check email
				if(!empty($_POST['email']))
				{
					if(strlen($_POST['email']) < 10)
					{
						echo 'Uw email klopt niet<br/>';
						$errorCheck = false;
					}
				}

				// Check password
				if($password != $retypePass)
				{
					echo 'Uw wachtwoorden komen niet overeen<br/>';
					$errorCheck = false;
				}
			
				if($errorCheck)
				{
					$misc = new Misc();
					$arrayValues['user_ID'] = $misc->getGUID();
					$arrayValues['Username'] = $username; 
					$arrayValues['Firstname'] = $firstname;
					$arrayValues['Lastname'] = $lastname;
					$arrayValues['Password'] = password_hash($password, PASSWORD_DEFAULT);
					$arrayValues['Email'] = $email;
					$arrayValues['Permission'] = 0;
					
					$this->db->insertDatabase('users', $arrayValues);
					echo 'Uw account is succesvol geregistreerd';
				}
			}
			else
			{
				echo 'Gebruikersnaam bestaat al';
			}
		}
	}

	// Change user
	public function update($username, $voornaam, $achternaam, $email,$class)
	{
		if(isset($_POST['accSubmit']))
		{
			if($username == $this->username)
			{
				goto skip;
			}
			$sth = $this->db->selectDatabase('users', 'Username', $username, '');
			if(!$row = $sth->fetch())
			{
				skip:
				$errorCheck = true;

				// Check username
				if(strlen($username) < 6)
				{
					echo 'Uw gebruikersnaam moet minimaal 6 karakters bevatten<br/>';
					$errorCheck = false;
				}
				if(is_numeric($username))
				{
					echo 'Uw gebruikersnaam moet letters bevatten<br/>';
					$errorCheck = false;
				}

				// Check email
				if(!empty($email))
				{
					if(strlen($email) < 10)
					{
						echo 'Uw email klopt niet<br/>';
						$errorCheck = false;
					}
				}

				// Check firstname
				if(is_numeric($voornaam))
				{
					echo 'Uw voornaam mogen alleen letters zijn<br/>';
					$errorCheck = false;
				}

				// Check lastname
				if(is_numeric($achternaam))
				{
					echo 'Uw achternaam mogen alleen letters zijn<br/>';
					$errorCheck = false;
				}

				if($errorCheck)
				{
					// Email confirm
					if($email != $this->email)
					{
						// Put mail in db
						$randNmb = rand(100000, 99999999);
						$arrayValues['user_ID'] = $this->id;
						$arrayValues['email'] = $email;
						$arrayValues['randNmb'] = $randNmb;
						$arrayValues['insertDate'] = time();
						$sth = $this->db->selectDatabase('email_confirm', 'email', $email, '');
						if($sth->fetch())
						{
							$this->db->updateDatabase('email_confirm', 'user_ID', $this->id, $arrayValues, '');
						}
						else
						{
							$this->db->insertDatabase('email_confirm', $arrayValues);
						}

						// Send mail
						$msg = "Klik op deze link om uw email te activeren.\nindex.php?pageStr=accountConfirm&randNmb=".$randNmb;
						$msg = wordwrap($msg,70);
						mail($email,"De Zevensprong | Mail confirmation",$msg);
						echo 'Een email is verstuurd naar de doorgegeven mail.<br/>Valideer uw email door deze link te bezoeken.<br/><br/>';
					}

					// Aanpassen van een klas (indien van toepassing)
					if(!empty($class))
					{
						$misc = new Misc();
						$arrayValues['teacher_ID'] = $misc->getGUID();
						$arrayValues['user_ID'] = $this->id;
						$arrayValues['class_ID'] = $class;
						$this->db->updateDatabase('teachers','user_ID',$this->id,$arrayValues,'');
					}

					// Basic info
					$arrayValues = array();
					$arrayValues['Username'] = $username;
					$arrayValues['Firstname'] = $voornaam;
					$arrayValues['Lastname'] = $achternaam;
					$this->db->updateDatabase('users', 'user_ID', $this->id, $arrayValues, '');

					echo 'Uw account is succesvol gewijzigd';
					return true;
				}
			}
			else
			{
				echo 'Gebruikersnaam bestaat al';
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

	// Password confirm
	public function passConfirm()
	{
		$randNmb = rand(100000, 99999999);
		$arrayValues['user_ID'] = $this->id;
		$arrayValues['randNmb'] = $randNmb;
		$arrayValues['insertDate'] = time();
		$sth = $this->db->selectDatabase('password_confirm', 'user_ID', $this->id, '');
		if($sth->fetch())
		{
			$this->db->updateDatabase('password_confirm', 'user_ID', $this->id, $arrayValues, '');
		}
		else
		{
			$this->db->insertDatabase('password_confirm', $arrayValues);
		}

		// Send mail
		$msg = 'Klik op 
		<a href="abyss-game.com/index.php?pageStr=passwordConfirm&randNmb='.$randNmb.'">deze link</a> om uw wachtwoord te wijzigen.
		';
		$msg = wordwrap($msg,70);
		$headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: admin@tovuti.com'; 
		mail($this->email,"Password change",$msg,$headers);
		echo 'Er is een link gestuurd naar uw e-mail adres.<br/>Verander uw wachtwoord door deze link te bezoeken.<br/><br/>';
	}

	// Change password
	public function changePassword($password, $passwordConfirm)
	{
		if($password != $passwordConfirm)
		{
			echo 'Uw wachtwoorden komen niet overeen';
			return false;
		}
		else
		{
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$arrayValues['Password'] = $hashedPassword;
			$this->db->updateDatabase('users', 'user_ID', $this->id, $arrayValues, '');
			return true;
		}
	}

	public function getStudentClass($ID)
	{
		$sth = $this->db->selectDatabase('students','user_ID',$ID,'');
		if($row = $sth->fetch())
		{
			$classSth = $this->db->selectDatabase('class','class_ID',$row['class_ID'],'');
			if($row = $classSth->fetch())
			{
				return $row['Name'];
			}
		}
	}

	public function getStudentClassID($ID)
	{
		$sth = $this->db->selectDatabase('students','user_ID',$ID,'');
		if($row = $sth->fetch())
		{
			$classSth = $this->db->selectDatabase('class','class_ID',$row['class_ID'],'');
			if($row = $classSth->fetch())
			{
				return $row['class_ID'];
			}
		}
	}

	public function getPermissionName($permissionLvl)
	{
		switch($permissionLvl)
		{
			case '1':
			return 'Student';
			break;

			case '2':
			return '<span class="w3-text-green">Docent</span> van klas '.$this->getTeacherClass($this->id);
			break;

			case '3':
			return '<span class="w3-text-red">Administrator</span>';
			break;

			default:
			return 'Gastaccount';
		}
	}

	public function getTeacherClass($ID)
	{
		$sth = $this->db->selectDatabase('teachers','user_ID',$ID,'');
		if($row = $sth->fetch())
		{
			$class = $row['class_ID'];
			$sth = $this->db->selectDatabase('class','class_ID',$class,'');
			if($row = $sth->fetch())
			{
				return '<a class="thread" href="?pageStr=class&class_id='.$row['class_ID'].'">'.$row['Name'].'</a>';
			}
			else return false;
		}
		else return false;

	}
}
?>