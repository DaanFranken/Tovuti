<?php
if($user->loginCheck())
{
	if(isset($_POST['uploadFile']))
	{
		// if(isset($_POST['']))
	}
	?>
	<div class="w3-container w3-margin">
		<div class="w3-card-4 w3-rest">
			<header class="w3-container w3-light-grey">
				<h3>Mijn portfolio</h3>
			</header>
			<div class="w3-container" style="height: 450px;">
				<?php
					$user->getUploadedFiles($user->id);
				?>
				<form action="" method="POST">
					<input type="submit" name="uploadFile" value="+" class="w3-button w3-circle w3-teal w3-right w3-medium w3-margin w3-card-4" style="padding: 10px 15px;">
				</form>
			</div>
		</div>
	</div>
	<?php
}
?>