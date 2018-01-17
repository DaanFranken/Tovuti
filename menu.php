<?php
if(isset($_POST['logout']))
{
	$user->logout();
}
?>
<a href="index.php" style="text-decoration: none;">
	<img src="images/deZevensprong.png" alt="de Zevensprong" class="mainMenuImage1">
</a>
<div id="mainMenuFullscreen" style="display: inline;">
<a href="index.php?pageStr=forum" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($pageStr, 'forum'); ?>>
		<div class="mainMenuLinkText">
			Forum
		</div>
	</div>
</a>
<a href="index.php?pageStr=class" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($pageStr, 'class'); ?>>
		<div class="mainMenuLinkText">
			Klassenlijsten
		</div>
	</div>
</a> 
<a href="index.php?pageStr=activities" class="mainMenuLink mainMenuLinkDiv">
	<div <?php $misc->menuCurrentPage($pageStr, 'activities'); ?>>
		<div class="mainMenuLinkText">
			Activiteiten
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
			<div class="mainMenuLinkPicture w3-right w3-margin-right w3-margin-left" <?php $misc->menuCurrentPage($pageStr, 'login'); ?>>
				<img src="images/logout.png" class="mainMenuImage2">
			</div>
		</span>
	</form>
	<a href="index.php?pageStr=account" class="mainMenuLink mainMenuLinkPicture w3-right">
		<div <?php $misc->menuCurrentPage($pageStr, 'account'); ?>>
			<img src="images/account.png" class="mainMenuImage2">
		</div>
	</a>
	<?php
}
else
{
	?>
	<a href="index.php?pageStr=login" class="mainMenuLink">
		<div class="mainMenuLinkPicture w3-right w3-margin-right" <?php $misc->menuCurrentPage($pageStr, 'login'); ?>>
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