<head>
<link rel="stylesheet" type="text/css" href="style/register.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
</head>
<div class="w3-container w3-teal">

  <h2>Registreren</h2>
</div>
<form class="w3-container" method="POST">
  <label class="w3-text-teal"><b>Gebruikersnaam</b></label>
  <input class="w3-input w3-border w3-light-grey" name="username" <?php if(isset($_POST['registerSubmit'])){echo 'value="'.$_POST['username'].'"';} ?> type="text" required>

  <label class="w3-text-teal"><b>Voornaam</b></label>
  <input class="w3-input w3-border w3-light-grey" name="fname" <?php if(isset($_POST['registerSubmit'])){echo 'value="'.$_POST['fname'].'"';} ?> type="text" required>

  <label class="w3-text-teal"><b>Achternaam</b></label>
  <input class="w3-input w3-border w3-light-grey" name="lname" <?php if(isset($_POST['registerSubmit'])){echo 'value="'.$_POST['lname'].'"';} ?> type="text" required>

  <label class="w3-text-teal"><b>Wachtwoord</b></label>
  <input class="w3-input w3-border w3-light-grey" name="password" <?php if(isset($_POST['registerSubmit'])){echo 'value="'.$_POST['password'].'"';} ?> type="Password" required>

   <label class="w3-text-teal"><b>Herhaal wachtwoord</b></label>
  <input class="w3-input w3-border w3-light-grey" name="password2" <?php if(isset($_POST['registerSubmit'])){echo 'value="'.$_POST['password2'].'"';} ?> type="Password" required>

   <label class="w3-text-teal"><b>E-mail</b></label>
  <input class="w3-input w3-border w3-light-grey" name="email" <?php if(isset($_POST['registerSubmit'])){echo 'value="'.$_POST['email'].'"';} ?> type="text" required>
  <br/>
  <input type="submit" class="w3-btn w3-blue-grey" value="Registreer" name="registerSubmit">
</form>
<a href="index.php?pageStr=login" id="login">
	Login
</a>

<?php
// Check if all values are set
if($misc->readVar('POST','username') 
	&& $misc->readVar('POST','fname')
	&& $misc->readVar('POST','lname') 
	&& $misc->readVar('POST','password')
	&& $misc->readVar('POST','password2')
	&& $misc->readVar('POST','email'))
{
	$username = $_POST['username'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	$email = $_POST['email'];

	if($user->register($username,$fname,$lname,$password,$password2,$email))
	{
		$user = new User($username);
		?>
		<script>
		setTimeout(function(){
			window.location.href = 'index.php';
		}, 2000);
		</script>
		<?php
	}
}
?>