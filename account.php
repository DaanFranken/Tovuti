<head>
	<link rel="stylesheet" type="text/css" href="style/account.css">
</head>
<?php
if($user->loginCheck())
{
	if(!$misc->readVar('GET','user_id'))
	{
		$check = false;

		if(isset($_POST['logout']))
		{
			$user->logout();
			echo '<script>window.location.href = "home";</script>';
		}

		if(isset($_POST['viewProfile']))
		{
			echo '<script>window.location.href = "account?user_id='.$user->id.'";</script>';	
		}
		// Change user information
		if($misc->readVar('POST','username') 
			&& $misc->readVar('POST','email'))
		{
			$username = $_POST['username'];
			$voornaam = $_POST['firstname'];
			$achternaam = $_POST['lastname'];
			$email = $_POST['email'];
			$class = null;
			if($user->permission == 2)
			{
				$class = $_POST['classList'];
			}
			if($user->update($username, $voornaam, $achternaam, $email, $class))
			{
				?>
				<script>
					setTimeout(function(){
						window.location.href = 'account';
					}, 1500);
				</script>
				<?php
				$check = true;
			}
		}

		// Change password
		if(isset($_POST['chgPass']))
		{
			$user->passConfirm();
			?>
			<script>
				setTimeout(function(){
					window.location.href = 'account';
				}, 3500);
			</script>
			<?php
			$check = true;
		}

		// Delete teacher from class
		if(isset($_POST['removeClassTeacher']))
		{
			$user->removeTeacherFromClass();
			?>
			<script>
				setTimeout(function(){
					window.location.href = 'account';
				}, 3500);
			</script>
			<?php
			$check = true;
		}
		?>
		<head>
			<link rel="stylesheet" type="text/css" href="account.css">
		</head>
		<?php
		if(!$check)
		{
			?>
			<form method="POST">
				<input type="submit" name="viewProfile" value="Bekijk mijn profiel" class="w3-btn w3-right" style="color: white;background-color: #89D162;">
			</form>
			<form action="" method="POST" id="logout">
				<input type="submit" name="logout" value="Uitloggen" class="w3-btn" style="color: white;background-color: #D17373;border-bottom: 2px solid #CF3030;">
			</form>
			<form action="" method="POST" style="position: absolute;top: 0;left: 110px;">
				<input type="submit" name="chgPass" value="Change password" class="w3-btn w3-blue-grey" style="border-bottom: 2px solid #275E7A;">
			</form>

			<div class="w3-margin">
				<form action="" method="POST" autocomplete="off">
					<label class="w3-text-teal"><b>Gebruikersnaam</b></label>
					<input type="text" name="username" value="<?php if(!isset($_POST['accSubmit'])){echo $user->username;}else{echo $_POST['username'];} ?>" class="w3-input w3-border w3-light-grey" placeholder="Gebruikersnaam" title="Gebruikersnaam" required>
					<label class="w3-text-teal"><b>Email</b></label><input type="text" name="email" value="<?php if(!isset($_POST['accSubmit'])){echo $user->email;}else{echo $_POST['email'];} 
					?>" class="w3-input w3-border w3-light-grey" title="Email | U krijgt een validatie mail om uw ingevoerde email goed te keuren" required>
					<label class="w3-text-teal"><b>Voornaam</b></label>
					<input type="text" name="firstname" value="<?php if(!isset($_POST['accSubmit'])){echo $user->firstname;}else{echo $_POST['firstname'];} ?>" class="w3-input w3-border w3-light-grey" placeholder="Voornaam" title="Voornaam" required>
					<label class="w3-text-teal"><b>Achternaam</b></label>
					<input type="text" name="lastname" value="<?php if(!isset($_POST['accSubmit'])){echo $user->lastname;}else{echo $_POST['lastname'];} ?>" class="w3-input w3-border w3-light-grey" placeholder="Achternaam" title="Achternaam" required>
					
					<br/>
					<input type="submit" name="accSubmit" value="Sla wijzigingen op" class="w3-btn" style="color: white;background-color: #89D162;border-bottom: 2px solid #58B327;">
					<?php 
					if($user->permission == 2)
					{
						echo '<label class="w3-text-teal"><b>Klas</b></label><br/>';
						$misc->dropdownClassList();
						?>
						<input type="submit" name="removeClassTeacher" value="X" class="w3-btn" style="color: #F1EEEF;background-color: #E41118;position: relative;display: inline;height: 41px;border: none;border-bottom: 2px solid #A30005;" title="Verwijder jezelf van deze klas">
						<?php
					}
					?>
				</form>
			</div>
			<?php
		}
	}

	else
	{
		// Profielpagina
		$user->getUserByID($_GET['user_id']);
		$name = $user->firstname . '&nbsp;' . $user->lastname;
		$permission = $user->permission;

		?>
		<div class="w3-container w3-margin">
			<div class="w3-card-4" style="width:30%;min-width: 350px;">
				<header class="w3-container w3-light-grey">
					<h3><?php echo $name; ?></h3>
				</header>
				<div class="w3-container w3-margin-top w3-margin-bottom">					
					<?php
					echo $user->getPermissionIcon($permission,'style="margin-right:20px;float:left;"');
					echo '<div class="w3-container w3-left" style="margin-top:-20px;"><h5>'.$user->getPermissionName($permission).'</h5>';
					echo '<i class="fa fa-envelope-o" aria-hidden="true"></i> '.$user->email .'</div>';
					?>
				</div>

				<?php $loggedInUser = new User($_SESSION['user_ID']); ?>
				<!-- Posts -->
				<?php
				if($loggedInUser->permission == 1)
				{
					?>
					<a class="thread w3-button w3-block w3-light-grey" style="text-decoration: none;" href="forum?user_id=<?php echo $user->id ?>"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;Posts</a>	
					<?php	
				}
				else
				{
					if($user->permission == 1)
					{
					?>
						<!-- Posts -->
						<a class="thread w3-button w3-block w3-light-grey" style="text-decoration: none;width:50%;float: left;" href="forum?user_id=<?php echo $user->id ?>"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;Posts</a>

						<!-- Uploads -->
						<a class="thread w3-button w3-block w3-light-grey" style="text-decoration: none;width:50%" href="portfolio?user_id=<?php echo $user->id ?>"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Uploads</a>
					<?php
					}
					else
					{
						?>
						<a class="thread w3-button w3-block w3-light-grey" style="text-decoration: none;" href="forum?user_id=<?php echo $user->id ?>"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;Posts</a>	
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}
else
{
	$user->showLoginMessage();
}
?>
<style>
	.langDiv{
		opacity: 1;
		transition: opacity 0.3s;
	}
</style>