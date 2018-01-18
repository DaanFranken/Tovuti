<?php
$check = false;
if($user->loginCheck())
{
	if(isset($_POST['uploadFile']))
	{
		if(isset($_POST['submitUpload']))
		{
			if($_FILES['uploadFile']['size'] != 0 && $_FILES['uploadFile']['error'] != 0)
			{
				$arrayValues['upload_ID'] = $misc->getGUID();
				$arrayValues['user_ID'] = $user->id;
				$arrayValues['title'] = $_POST['title'];
				$arrayValues['type'] = strtolower(pathinfo($_FILES['uploadFile'], PATHINFO_EXTENSION));
				$arrayValues['uploadContent'] = $_FILES['uploadFile'];
				$arrayValues['uploadDate'] = date();
				$sth = insertDatabase('upload', $arrayValues);
				echo '<script src="?pageStr=portfolio"></script>';
			}
			else
			{
				include 'uploadForm.php';
			}
		}
		else
		{
			include 'uploadForm.php';
		}
		$check = true;
	}
	if(!$check)
	{
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
}
?>