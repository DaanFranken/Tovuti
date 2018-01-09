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
<a href="index.php?pageStr=thread" class="mainMenuLink mainMenuLinkDiv">
		<div <?php $misc->menuCurrentPage($pageStr, 'thread'); ?>>
			<div class="mainMenuLinkText">
				Thread
			</div>
		</div>
	</a> 
	<?php
	if($user->loginCheck())
	{
		?>
		<a href="index.php?pageStr=account" class="mainMenuLink mainMenuLinkPicture">
			<div <?php $misc->menuCurrentPage($pageStr, 'account'); ?>>
				<img src="images/account.png" class="mainMenuImage2">
			</div>
		</a>
		<form action="" method="post" id="logoutForm" style="display: inline">
			<input type="hidden" name="logout" value="true">
			<span class="mainMenuLink" onclick="logout()">
				<div class="mainMenuLinkPicture" <?php $misc->menuCurrentPage($pageStr, 'login'); ?>>
					<img src="images/logout.png" class="mainMenuImage2">
				</div>
			</span>
		</form>
		<?php
	}
	else
	{
		?>
		<a href="index.php?pageStr=login" class="mainMenuLink">
			<div class="mainMenuLinkPicture" <?php $misc->menuCurrentPage($pageStr, 'login'); ?>>
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