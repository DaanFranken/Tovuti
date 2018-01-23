<?php
if($user->loginCheck() && $user->permission == 3)
{
	if(isset($_POST['delUserAcc']))
	{
		if(isset($_POST['delUserAccConfirm']))
		{
			$arrayValues['Status'] = 0;
			$db->updateDatabase('users', 'user_ID', $_POST['user_ID'], $arrayValues, '');
			echo '<script>window.location.href = "admin";</script>';
		}
		else
		{
			?>
			<form action="admin" method="POST" id="delUserForm" style="display: none !important;">
				<input type="hidden" name="delUserAcc" value="true">
				<input type="hidden" name="delUserAccConfirm" value="true">
				<input type="hidden" name="user_ID" value="<?php echo $_POST['user_ID']; ?>">
			</form>
			<script>
			if(confirm('Weet u zeker dat u dit account wilt deactiveren?')){
				document.getElementById('delUserForm').submit();
			}
			else{
				window.location.href = 'admin';
			}
			</script>
			<?php
		}
	}
	elseif(isset($_POST['activateUserAcc']))
	{
		$arrayValues['Status'] = 1;
		$db->updateDatabase('users', 'user_ID', $_POST['user_ID'], $arrayValues, '');
		echo '<script>window.location.href = "admin";</script>';
	}
	elseif(isset($_POST['changeUserPerm']))
	{
		$sth = $db->selectDatabase('users', 'user_ID', $_POST['user_ID'], '');
		if($row = $sth->fetch())
		{
			if(isset($_POST['saveChangedPerm']))
			{
				$sth = $db->selectDatabase('users', 'user_ID', $_POST['user_ID'], '');
				if($sth->fetch())
				{
					$arrayValues = array();
					$arrayValues['Permission'] = $_POST['userPerm'];
					$db->updateDatabase('users', 'user_ID', $_POST['user_ID'], $arrayValues, '');
					if($_POST['user_ID'] != 2)
					{
						$sth = $db->selectDatabase('teachers', 'user_ID', $_POST['user_ID'], '');
						if($sth->fetch())
						{
							$db->deleteDatabase('teachers', 'user_ID', $_POST['user_ID'], '');
						}
					}
					if($_POST['user_ID'] != 1)
					{
						$sth = $db->selectDatabase('students', 'user_ID', $_POST['user_ID'], '');
						if($sth->fetch())
						{
							$db->deleteDatabase('students', 'user_ID', $_POST['user_ID'], '');
						}
					}
					if($_POST['userPerm'] == 1)
					{
						$arrayValues = array();
						$arrayValues['student_ID'] = $misc->getGUID();
						$arrayValues['user_ID'] = $_POST['user_ID'];
						$arrayValues['studentNumber'] = $misc->getGUID();
						$db->insertDatabase('students', $arrayValues);
					}
					if($_POST['userPerm'] == 2)
					{
						$arrayValues = array();
						$arrayValues['teacher_ID'] = $misc->getGUID();
						$arrayValues['user_ID'] = $_POST['user_ID'];
						$db->insertDatabase('teachers', $arrayValues);
					}
					echo '<script>window.location.href = "admin";</script>';
				}
				else
				{
					echo '<script>window.location.href = "admin";</script>';
				}
			}
			else
			{
				?>
				<a href="admin" class="thread">
					Terug
				</a>
				<form action="admin" method="POST">
					<input type="hidden" name="changeUserPerm" value="true">
					<input type="hidden" name="user_ID" value="<?php echo $_POST['user_ID']; ?>">
					<select name="userPerm">
						<option value="0">
							Normaal account
						</option>
						<option value="1" <?php if($row['Permission'] == 1){echo 'style="color: #177D97;" selected';} ?>>
							Student account
						</option>
						<option value="2" <?php if($row['Permission'] == 2){echo 'style="color: #177D97;" selected';} ?>>
							Docent account
						</option>
						<option value="3" <?php if($row['Permission'] == 3){echo 'style="color: #177D97;" selected';} ?>>
							Admin account
						</option>
					</select>
					<input type="submit" name="saveChangedPerm" value="Pas toe">
				</form>
				<?php
			}
		}
		else
		{
			echo '<script>window.location.href = "admin";</script>';
		}
	}
	else
	{
		?>
		<div class="w3-container w3-margin">
			<div class="w3-card-4 w3-rest">
				<header class="w3-container w3-light-grey">
					<h3>Alle gebruikers</h3>
					<div class="w3-container">
						<div style="color: #6B6B6B;padding-bottom: 5px;">
							<div class="userText" style="left: -20px;width: 32.5%;">Gebruikersnaam</div>
							<div class="userText" style="width: 33%;">Voornaam</div>
							<div class="userText" style="width: 30%;">Achternaam</div>
						</div>
					</div>
				</header>
				<?php
				$sth = $db->selectDatabase('users', '', '', '');
				while($row = $sth->fetch())
				{
					?>
					<div class="w3-container">
						<a class="user" <?php if($row['Status'] == 1){echo 'href="account?user_id='.$row['user_ID'].'"';} ?> <?php if($row['Status'] == 0){echo 'style="color: #D6000B;cursor: not-allowed;" title="Gedeactiveerd account"';} ?>><?php echo '<div class="userText">'.$row['Username'].'</div><div class="userText">'.$row['Firstname'].'</div><div class="userText">'.$row['Lastname'].'</div>'; ?></a>
						<form action="admin" method="POST">
							<input type="hidden" name="user_ID" value="<?php echo $row['user_ID']; ?>">
							<?php
							if($row['Status'] == 1)
							{
								?>
								<input type="submit" name="delUserAcc" value="X" class="w3-btn w3-right w3-margin-left" style="color: #F1EEEF;background-color: #C2000D;position: relative;top:-25px;height: 41px;opacity: 0.5;border: none;border-bottom: 2px solid #A30005;border-radius: 5px;" title="Deactiveer account">
								<input type="submit" name="changeUserPerm" value="Verander rechten" class="w3-btn w3-right" style="color: #F1EEEF;background-color: #89D162;position: relative;top:-25px;height: 41px;border: none;border-bottom: 2px solid #58B327;border-radius: 5px;">
								<?php
							}
							else
							{
								?>
								<input type="submit" name="activateUserAcc" class="w3-btn w3-right" style="color: #F1EEEF;background-color: #89D162;position: relative;top:-25px;" value="&check;" title="Activeer account">
								<?php
							}
							?>
						</form>
					</div>
					<?php
				}
				echo '<style>.w3-btn{transition: all 0.2s;}.w3-btn:hover{opacity: 1 !important;}</style>';
				?>
			</div>
		</div>
		<style>
		.user{
			color: #2C9AC9;
			height: 50px;
			padding-top: 5px;
			padding-bottom: 5px;
			text-decoration: none;
		}

		.user:hover{
			background-color: #F5F5F5;
		}

		.userText{
			position: relative;
			display: inline-block;
			width: 33.3%;
			top: 5px;
			padding-left: 5px;
			overflow: hidden;
		}
		</style>
		<?php
	}
}
else
{
	echo '<script>window.location.href = "home";</script>';
}
?>