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
			echo '<script>window.location.href = "index.php?pageStr=home";</script>';
		}

		if(isset($_POST['viewProfile']))
		{
			echo '<script>window.location.href = "index.php?pageStr=account&user_id='.$user->id.'";</script>';	
		}

	// Change user information
		if($misc->readVar('POST','username') 
			&& $misc->readVar('POST','email'))
		{
			$username = $_POST['username'];
			$voornaam = $_POST['firstname'];
			$achternaam = $_POST['lastname'];
			$email = $_POST['email'];
			$class = $_POST['classList'];


			if($user->update($username, $voornaam, $achternaam, $email,$class))
			{
				?>
				<script>
					setTimeout(function(){
						window.location.href = 'index.php?pageStr=account';
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
					window.location.href = 'index.php?pageStr=account';
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
					
					<?php 
					if($user->permission == 2)
					{
						echo '<label class="w3-text-teal"><b>Klas</b></label><br/>';
						$misc->dropdownClassList();
					}
					?>
					<br/>

					<input type="submit" name="accSubmit" value="Sla alles op" class="w3-btn" style="color: white;background-color: #89D162;position: absolute;top: 0;left: 282px;border-bottom: 2px solid #58B327;">
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
			<div class="w3-card-4" style="width:40%;min-width: 350px;">
				<header class="w3-container w3-light-grey">
					<h3><?php echo $name; ?></h3>
				</header>
				<div class="w3-container w3-margin">					
					<?php
					echo $user->getPermissionIcon($permission,'style="margin-right:20px;float:left;"');
					echo '<div class="w3-container w3-left" style="margin-top:-20px;"><h4>'.$user->getPermissionName($permission).'</h4>';
					echo '<i class="fa fa-envelope-o" aria-hidden="true"></i> '.$user->email .'</div>';
					?>
				</div>
				<a class="thread w3-button w3-block w3-light-grey" style="text-decoration: none;" href="?pageStr=forum&user_id=<?php echo $user->id ?>"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;Posts van <?php echo $name; ?></a>
			</div>
		</div>
		<?php
	}
}
else
{
	echo 'U dient in te loggen om deze pagina te bekijken';
}
?>
<style>
	.langDiv{
		opacity: 1;
		transition: opacity 0.3s;
	}
</style>