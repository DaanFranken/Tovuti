<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
</head>
<div class="w3-container w3-teal">

  <h2>Login</h2>
</div>
<form class="w3-container" method="POST">
  <label class="w3-text-teal"><b>Username</b></label>
  <input class="w3-input w3-border w3-light-grey" name="username" type="text" required>

  <label class="w3-text-teal"><b>Password</b></label>
  <input class="w3-input w3-border w3-light-grey" name="password" type="Password" required>
  <br/>
  <input type="submit" class="w3-btn w3-blue-grey" value="Login" name="loginSubmit">
</form>

<?php
if($misc->readVar('POST','username') && $misc->readVar('POST','password'))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = new User($username);

	if($user->login($username,$password))
	{
		
	}
	else
	{
		// Login failed
	}
} 

?>

