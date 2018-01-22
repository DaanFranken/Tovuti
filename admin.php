<?php
if($user->loginCheck() && $user->permission == 3)
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
					<a class="user" href="account?user_id=<?php echo $row['user_ID']; ?>"><?php echo '<div class="userText">'.$row['Username'].'</div><div class="userText">'.$row['Firstname'].'</div><div class="userText">'.$row['Lastname'].'</div>'; ?></a><br/>
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
else
{
	echo '<script>window.location.href = "home";</script>';
}
?>