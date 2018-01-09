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
		$email = $_POST['email'];

		if($user->update($username, $email))
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
			<input type="submit" name="logout" value="Logout">
		</form>
		<form action="" method="POST" autocomplete="off">
			<input type="text" name="username" value="<?php if(!isset($_POST['accSubmit'])){echo $user->username;}else{echo $_POST['username'];} ?>" class="inputField" title="Gebruikersnaam" required>
			<input type="text" name="email" value="<?php if(!isset($_POST['accSubmit'])){echo $user->email;}else{echo $_POST['email'];} ?>" class="inputfield" title="Email | U krijgt een validatie mail om uw ingevoerde email goed te keuren" required>

			<input type="submit" name="accSubmit" value="Sla alles op">
		</form>
		<form action="" method="POST">
			<input type="submit" name="chgPass" value="Change password">
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