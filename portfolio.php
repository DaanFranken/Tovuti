<?php
$check = false;
if($user->loginCheck())
{
	if(isset($_POST['uploadFile']))
	{
		if(isset($_POST['submitUpload']))
		{
			if($_FILES['uploadFile']['size'] != 0 && $_FILES['uploadFile']['size'] < 10485760)
			{
				$fileType = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
				if($fileType == 'xlsx' || $fileType == 'xls' || $fileType == 'docx' || $fileType == 'doc' || $fileType == 'pdf' || $fileType == 'ppt' || $fileType == 'pptx' || $fileType == 'zip')
				{
					$arrayValues['upload_ID'] = $misc->getGUID();
					$arrayValues['user_ID'] = $user->id;
					$arrayValues['title'] = $_FILES['uploadFile']['name'];
					$arrayValues['type'] = $fileType;
					$arrayValues['uploadContent'] = addslashes(file_get_contents($_FILES['uploadFile']['tmp_name']));
					$arrayValues['uploadDate'] = date("Y-m-d H:i:s");
					$db->insertDatabase('upload', $arrayValues);
					echo '<script>window.location.href = "portfolio";</script>';
				}
				else
				{
					echo 'U kunt alleen deze vorm bestanden uploaden: "xlsx - xls - docx - doc - pdf - ppt - pptx - zip "<br/>';
					include 'uploadForm.php';
				}
			}
			else
			{
				if($_FILES['uploadFile']['size'] > 10485760)
				{
					echo 'Uw bestand kan niet groter zijn dan 10 Megabytes<br/>';
				}
				elseif($_FILES['uploadFile']['size'] == 0)
				{
					echo 'U kunt geen lege bestanden uploaden<br/>';
				}
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