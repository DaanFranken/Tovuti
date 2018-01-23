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
	public function update($username, $voornaam, $achternaam, $email, $class)
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
						$msg = "Klik op deze link om uw email te activeren.\naccountConfirm?randNmb=".$randNmb;
						$msg = wordwrap($msg,70);
						mail($email,"De Zevensprong | Mail confirmation",$msg);
						echo 'Een email is verstuurd naar de doorgegeven mail.<br/>Valideer uw email door deze link te bezoeken.<br/><br/>';
					}

					// Aanpassen van een klas
					if(!empty($class))
					{
						$misc = new Misc();
						$arrayValues = array();
						$sth = $this->db->selectDatabase('teachers', 'user_ID', $this->id, '');
						if($sth->fetch())
						{
							$arrayValues['class_ID'] = $class;
							$this->db->updateDatabase('teachers', 'user_ID', $this->id, $arrayValues, '');
						}
						else
						{
							$arrayValues['teacher_ID'] = $misc->getGUID();
							$arrayValues['user_ID'] = $this->id;
							$arrayValues['class_ID'] = $class;
							$this->db->insertDatabase('teachers', $arrayValues);
						}
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
		<a href="abyss-game.com/passwordConfirm?randNmb='.$randNmb.'">deze link</a> om uw wachtwoord te wijzigen.
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
			else return false;
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
			else return false;
		}
	}

	public function getPermissionName($permissionLvl)
	{
		switch($permissionLvl)
		{			
			case '1':
			if($this->getStudentClassID($this->id))
			{
				return 'Student in klas <a class="thread" href="class?class_id='.$this->getStudentClassID($this->id).'">'.$this->getStudentClass($this->id).'</a>';
			}
			else return 'Student';			
			break;

			case '2':
			$row = $this->getTeacherClass($this->id);
			if($row)
			{
				return '<span class="w3-text-green">Docent</span> van klas <a class="thread" href="class?class_id='.$row['class_ID'].'">'.$row['Name'].'</a>';
			}
			else return '<span class="w3-text-green">Docent</span>';			
			break;

			case '3':
			return '<span class="w3-text-red">Administrator</span>';
			break;

			default:
			return 'Gastaccount';
		}
	}

	public function getPermissionIcon($permissionLvl,$style)
	{
		switch($permissionLvl)
		{
			case '1':
			return '<i class="fa fa-3x fa-graduation-cap" '.$style .' aria-hidden="true"></i>';
			break;

			case '2':
			return '<i class="fa fa-3x fa-book" '.$style .' aria-hidden="true"></i>';
			break;

			case '3':
			return '<i class="fa fa-3x fa-cog w3-spin" '.$style.' aria-hidden="true"></i>';
			break;

			default:
			return '<i class="fa fa-3x fa-user-times w3-left" aria-hidden="true"></i>';
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
				return $row;
			}
			else return false;
		}
		else return false;
	}

	public function getTeacherByClassID($ID)
	{
		$sth = $this->db->selectDatabase('teachers','class_ID',$ID,'');
		if($row = $sth->fetch())
		{
			$teacherID = $row['user_ID'];
			$sth = $this->db->selectDatabase('users','user_ID',$teacherID,'');
			if($row = $sth->fetch())
			{
				return '<a class="thread" href="account?user_id='.$teacherID.'">'.$row['Firstname'] .'&nbsp;'.$row['Lastname'].'</a>';
			}
			else return false;
		}
		else return false;
	}

	public function getUploadedFiles($ID)
	{
		$sth = $this->db->selectDatabase('upload','user_ID',$ID,'');
		$result = $sth->fetchAll();

		if(!$result)
		{
			echo 'Je hebt nog geen bestanden toegevoegd aan je persoonlijke portfolio.';
		}
		else
		{
			echo 'Klik op een link om het bestand te downloaden';
			echo '<ul class="w3-ul w3-card-4">';
			foreach($result as $file)
			{
				$unformattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $file['uploadDate']);
				$formattedDate = $unformattedDate->format('d-m-Y H:i:s');
				?>
				
					<li>
						<?php 
						$this->getUploadStatusIcon($file['status']);
							echo '<a class="thread" href="download.php?file_id='.$file['upload_ID'].'">'.$file['title'].'</a>';
						?>
						<span class="w3-right"><?php echo $formattedDate; ?></span>	
					</li>
				<?php
			}
			echo '</ul>';
		}
	}

	public function getUploadedFilesByClassID($ID)
	{
		$sth = $this->db->selectDatabase('students','class_ID',$ID,'');
		$result = $sth->fetchAll();
		echo 'Klik op een link om het bestand te downloaden';
		echo '<ul class="w3-ul w3-card-4">';

		foreach($result as $students)
		{
			$studentID = $students['user_ID'];
			$sth = $this->db->selectDatabase('upload','user_ID',$studentID,'');
			$result = $sth->fetchAll();
			
			foreach($result as $uploadFile)
			{
				$unformattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $uploadFile['uploadDate']);
				$formattedDate = $unformattedDate->format('d-m-Y H:i:s');
				$uploader = new User($studentID);
				?>
				
					<li>
						<?php 
						$this->getUploadStatusIcon($uploadFile['status']);
							echo '<a class="thread" href="download.php?file_id='.$uploadFile['upload_ID'].'">'.$uploadFile['title'].'</a>';
						?>
						<span class="w3-right w3-margin-left">@<?php echo $formattedDate; ?></span>
						<span class="w3-right w3-margin-right">Geüpload door <?php echo '<a class="thread" href="account?user_id='.$uploader->id.'">'. $uploader->firstname .'&nbsp;'. $uploader->lastname .'</a>'; ?></span>

					</li>
				<?php
			}
		}			
	}

	public function getUploadStatusIcon($status)
	{
		switch ($status) 
		{
			# Nog niet gezien
			case '0':
				echo '<div class="tooltip"><i class="fa fa-eye-slash w3-margin-right w3-text-red" aria-hidden="true"><span class="tooltiptext">Nog niet gezien</span></div></i>';
				break;
			# Gezien
			case '1':
				echo '<div class="tooltip"><i class="fa fa-eye w3-margin-right w3-text-green" aria-hidden="true"><span class="tooltiptext">Gezien</span></div></i>';
				break;
			
			default:
				# code...
		}
	}

	public function showLoginMessage()
	{
		echo '<span class="w3-margin">U dient <a class="thread" href="login">in te loggen</a> om deze pagina te bekijken.</span>';
	}

    public function removeTeacherFromClass()
    {
    	$sth = $this->db->selectDatabase('teachers', 'user_ID', $this->id, '');
    	if($sth->fetch())
    	{
        	$this->db->deleteDatabase('teachers', 'user_ID', $this->id, '');
        	echo 'Uw bent succesvol van uw klas verwijderd';
        }
        else
        {
        	echo 'U bent niet toegewezen aan een klas';
        }
    }
}
?>