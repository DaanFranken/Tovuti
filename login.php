<head>
<link rel="stylesheet" type="text/css" href="style/login.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
</head>
<div class="w3-container w3-teal">
<h2>Inloggen</h2>
</div>
<?php
$user = new User();
if($user->loginCheck())
{
	echo 'U bent al ingelogd';
}
else
{
	?>
	<form class="w3-container" method="POST">
	  <label class="w3-text-teal"><b>Gebruikersnaam of student nummer</b></label>
	  <input class="w3-input w3-border w3-light-grey" name="username" <?php if(isset($_POST['loginSubmit'])){echo 'value="'.$_POST['username'].'"';} ?> type="text" required>

	  <label class="w3-text-teal"><b>Wachtwoord</b></label>
	  <input class="w3-input w3-border w3-light-grey" name="password" <?php if(isset($_POST['loginSubmit'])){echo 'value="'.$_POST['password'].'"';} ?> type="Password" required>
	  <br/>
	  <input type="submit" class="w3-btn w3-blue-grey" value="Login" name="loginSubmit">
	</form>

	<a href="index.php?pageStr=register" id="register">
		Registreer
	</a>
	<?php
}
if($misc->readVar('POST','username') && $misc->readVar('POST','password'))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = new User();

	if($user->login($username,$password))
	{
		echo '<script>window.location.href = "index.php";</script>';
	}
}
?>