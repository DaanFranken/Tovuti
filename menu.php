<?php
if(isset($_POST['logout']))
{
	$user->logout();
}
?>
<a href="home" style="text-decoration: none;">
	<img src="images/deZevensprong.png" alt="de Zevensprong" class="mainMenuImage1">
</a>
<div id="mainMenuFullscreen" style="display: inline;">
<a href="forum" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'forum'); ?>>
		<div class="mainMenuLinkText">
			Forum
		</div>
	</div>
</a>
<a href="class" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'class'); ?>>
		<div class="mainMenuLinkText">
			Klassenlijsten
		</div>
	</div>
</a> 
<a href="activities" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'activities'); ?>>
		<div class="mainMenuLinkText">
			Activiteiten
		</div>
	</div>
</a> 
<?php 
if($user->permission == 1)
{
	?>
	<a href="portfolio" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'portfolio'); ?>>
		<div class="mainMenuLinkText">
			Mijn portfolio
		</div>
	</div>
	</a> 
<?php
}

if($user->permission == 2 && $user->getTeacherClass($user->id))
{
	$row = $user->getTeacherClass($user->id);
	?>
	<a href="portfolio?class_id=<?php echo $row['class_ID']; ?>" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'portfolio'); ?>>
		<div class="mainMenuLinkText">
			Mijn klas
		</div>
	</div>
	</a> 
<?php
}

if($user->permission == 3)
{
	?>
	<a href="admin" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'admin'); ?>>
		<div class="mainMenuLinkText">
			Admin menu
		</div>
	</div>
	</a> 
	<?php
}
?>
<a href="contact" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($uri, 'contact'); ?>>
		<div class="mainMenuLinkText">
			Contact
		</div>
	</div>
</a>
<?php
if($user->loginCheck())
{
	?>
	
	<form action="" method="post" id="logoutForm" style="display: inline">
		<input type="hidden" name="logout" value="true">
		<span class="mainMenuLink" onclick="logout()">
			<div class="mainMenuLinkPicture w3-right w3-margin-right w3-margin-left" <?php $misc->menuCurrentPage($uri, 'login'); ?>>
				<img src="images/logout.png" class="mainMenuImage2">
			</div>
		</span>
	</form>
	<a href="account" class="mainMenuLink mainMenuLinkPicture w3-right">
		<div <?php $misc->menuCurrentPage($uri, 'account'); ?>>
			<img src="images/account.png" class="mainMenuImage2">
		</div>
	</a>
	<?php
}
else
{
	?>
	<a href="login" class="mainMenuLink">
		<div class="mainMenuLinkPicture w3-right w3-margin-right" <?php $misc->menuCurrentPage($uri, 'login'); ?>>
			<img src="images/login.png" class="mainMenuImage2">
		</div>
	</a>
	<?php
}
?>
</div>
<div id="mainMenuWindowed">

</div>
<script>
	function logout(){
		document.getElementById('logoutForm').submit();
	}
</script>