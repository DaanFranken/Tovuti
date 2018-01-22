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
								<input type="submit" name="delUserAcc" value="X" title="Deactiveer account">
								<?php
							}
							else
							{
								?>
								<input type="submit" name="activateUserAcc" value="&check;" title="Activeer account">
								<?php
							}
							?>
						</form>
					</div>
					<?php
				}
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