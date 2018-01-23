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
					echo 'U kunt alleen de volgende bestanden uploaden: "xlsx - xls - docx - doc - pdf - ppt - pptx - zip "<br/>';
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
					<?php 
						if($user->permission == 2 && $user->getTeacherClass($user->id) && ($misc->readVar('GET','class_id')) || $misc->readVar('GET','file_id'))
						{
							echo '<h3>Mijn klas</h3>';
						}
						else echo '<h3>Mijn portfolio</h3>';
					?>
					
				</header>
				<div class="w3-container w3-display-container" style="height: 450px;">
					<?php
						if(!$misc->readVar('GET','class_id') && !$misc->readVar('GET','file_id') && !$misc->readVar('GET','user_id'))
						{
							$user->getUploadedFiles($user->id);
						}
						elseif($misc->readVar('GET','user_id'))
						{
							if($user->permission > 1)
							{
								$user->getUploadedFiles($_GET['user_id']);
							}
							else echo 'U heeft geen rechten om deze pagina te bekijken.';
						}
						else
						{
							// Docent
							if($user->permission == 2)
							{
								if($misc->readVar('GET','class_id'))
								{
									$user->getUploadedFilesByClassID($_GET['class_id']);
								}
								if($misc->readVar('GET','file_id'))
								{
									if($file = $misc->getUploadDetails($_GET['file_id']))
									{
										$sth = $db->selectDatabase('users','user_ID', $file['user_ID'],'');
										$uploader = $sth->fetch();
										$unformattedDate = DateTime::createFromFormat('Y-m-d H:i:s', $file['uploadDate']);
										$formattedDate = $unformattedDate->format('d-m-Y H:i:s');
										?>
										

										<?php
										echo 'Klik hier om het bestand van <a class="thread" href="account?user_id='.$uploader['user_ID'].'">'.$uploader['Firstname'].'&nbsp;'.$uploader['Lastname'].'</a> te downloaden:<br/><a class="thread" href="download.php?file_id='.$file['upload_ID'].'">'.$file['title'].'</a>';
										echo '<br/><br/>';
										echo 'Geüpload op '.$formattedDate;
										$grade = $file['grade'];
										$status = $file['status'];
										?>
										<hr/>
										<div class="w3-row">
											<form method="POST">
											<!-- Cijfer -->
											<div class="w3-col l1 s12 w3-left">
											<label class="w3-text-teal"><b>Cijfer</b><br/></label>	
											<select name="cijfer">	
												<option <?php if($grade == 0) echo 'selected'; ?> value="0">0</option>
												<option <?php if($grade == 1) echo 'selected'; ?> value="1">1</option>
												<option <?php if($grade == 2) echo 'selected'; ?> value="2">2</option>
												<option <?php if($grade == 3) echo 'selected'; ?> value="3">3</option>
												<option <?php if($grade == 4) echo 'selected'; ?> value="4">4</option>
												<option <?php if($grade == 5) echo 'selected'; ?> value="5">5</option>
												<option <?php if($grade == 6) echo 'selected'; ?> value="6">6</option>
												<option <?php if($grade == 7) echo 'selected'; ?> value="7">7</option>
												<option <?php if($grade == 8) echo 'selected'; ?> value="8">8</option>
												<option <?php if($grade == 9) echo 'selected'; ?> value="9">9</option>
												<option <?php if($grade == 10) echo 'selected'; ?> value="10">10</option>
											</select>
											</div>

											<!-- Status -->
											<div class="w3-col l1 s12">
											<label class="w3-text-teal"><b>Status</b><br/></label>	
											<select name="status">	
												<option <?php if($status == 0) echo 'selected'; ?> value="0">Niet gezien</option>
												<option <?php if($status == 1) echo 'selected'; ?> selected value="1">Gezien</option>						
												<option <?php if($status == 2) echo 'selected'; ?> value="2">Te laat</option>
											</select>
											</div>
										</div>
											<input type="submit" name="submitGrade" value="Beoordeel werk" class="w3-btn w3-display-bottomleft w3-margin" style="color: white;background-color: #89D162;">
										</form>

										<?php

									}
									else echo 'Bestand is niet gevonden.';

								}
							}
							else
							{
								echo 'U heeft geen rechten om deze pagina te bekijken.';
							}
						}						
					?>
					<?php
					if(!$misc->readVar('GET','class_id') && !$misc->readVar('GET','user_id'))
					{
						if($user->permission == 1) 
						{
						?>
						<form action="" method="POST">
							<input type="submit" name="uploadFile" value="+" class="w3-button w3-circle w3-teal w3-right w3-medium w3-margin w3-card-4" style="padding: 10px 15px;">
						</form>
						<?php 
						}
					}


					// Beoordeel werk 
					if($misc->readVar('POST','submitGrade'))
					{
						$class = $user->getTeacherClass($user->id);
						$updateArray['status'] = $_POST['status'];
						$updateArray['grade'] = $_POST['cijfer'];
						$db->updateDatabase('upload', 'upload_ID', $_GET['file_id'], $updateArray, '');
						echo '<script>window.location.href = "portfolio?class_id='.$class['class_ID'].'";</script>';
					}
				?>
				</div>
			</div>
		</div>
		<?php
	}
}
?>