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
			<input type="text" name="username" value="<?php if(!isset($_POST['accSubmit'])){echo $user->username;}else{echo $_POST['username'];} ?>" class="inputField" title="Username" required>
			<input type="text" name="email" value="<?php if(!isset($_POST['accSubmit'])){echo $user->email;}else{echo $_POST['email'];} ?>" class="inputfield" title="Email | You will receive a confirmation mail if you enter a new email" required>

			<input type="submit" name="accSubmit" value="Apply all changes">
		</form>
		<form action="" method="POST">
			<input type="submit" name="chgPass" value="Change password">
		</form>
		<?php
	}
}
else
{
	echo 'You need to be logged in to view your account';
}
?>
<style>
.langDiv{
	opacity: 1;
	transition: opacity 0.3s;
}
</style>