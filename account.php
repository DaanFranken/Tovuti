<head>
	<link rel="stylesheet" type="text/css" href="style/account.css">
</head>
<?php
if($user->loginCheck())
{
	$check = false;

	if(isset($_POST['logout']))
	{
		$user->logout();
		echo '<script>window.location.href = "index.php?pageStr=home";</script>';
	}

	// Change user information
	if($misc->readVar('POST','username') 
	&& $misc->readVar('POST','email'))
	{
		$username = $_POST['username'];
		$voornaam = $_POST['firstname'];
		$achternaam = $_POST['lastname'];
		$email = $_POST['email'];

		if($user->update($username, $voornaam, $achternaam, $email))
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
		<form action="" method="POST" id="logout">
			<input type="submit" name="logout" value="Uitloggen" class="w3-btn" style="color: white;background-color: #D17373;border-bottom: 2px solid #CF3030;">
		</form>
		<form action="" method="POST" style="position: absolute;top: 0;left: 110px;">
			<input type="submit" name="chgPass" value="Change password" class="w3-btn w3-blue-grey" style="border-bottom: 2px solid #275E7A;">
		</form>
		<form action="" method="POST" autocomplete="off">
			<label class="w3-text-teal"><b>Gebruikersnaam</b></label>
			<input type="text" name="username" value="<?php if(!isset($_POST['accSubmit'])){echo $user->username;}else{echo $_POST['username'];} ?>" class="w3-input w3-border w3-light-grey" placeholder="Gebruikersnaam" title="Gebruikersnaam" required>
			<label class="w3-text-teal"><b>Email</b></label><input type="text" name="email" value="<?php if(!isset($_POST['accSubmit'])){echo $user->email;}else{echo $_POST['email'];} 
			?>" class="w3-input w3-border w3-light-grey" title="Email | U krijgt een validatie mail om uw ingevoerde email goed te keuren" required>
			<label class="w3-text-teal"><b>Voornaam</b></label>
			<input type="text" name="firstname" value="<?php if(!isset($_POST['accSubmit'])){echo $user->firstname;}else{echo $_POST['firstname'];} ?>" class="w3-input w3-border w3-light-grey" placeholder="Voornaam" title="Voornaam" required>
			<label class="w3-text-teal"><b>Achternaam</b></label>
			<input type="text" name="lastname" value="<?php if(!isset($_POST['accSubmit'])){echo $user->lastname;}else{echo $_POST['lastname'];} ?>" class="w3-input w3-border w3-light-grey" placeholder="Achternaam" title="Achternaam" required>

			<input type="submit" name="accSubmit" value="Sla alles op" class="w3-btn" style="color: white;background-color: #89D162;position: absolute;top: 0;left: 282px;border-bottom: 2px solid #58B327;">
		</form>
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