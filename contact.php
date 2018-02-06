<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/contact.css">
	<link rel="stylesheet" type="text/css" href="style/home.css">
</head>
<body>
	<h3 class="contactTitle">
		Contact
	</h3>
	<div class="container">
		<div class="w3-col l4">
			<h5 class="contactFormTitle">
				Stuur ons een mail
			</h5>
			<form action="#" class="contactForm" method="POST">
				Uw mail<br>
				<input type="text" name="userEmail" id="userEmail" placeholder="voorbeeld@hotmail.com" required><br><br>
				Onderwerp<br>
				<input type="email" name="emailSubject" id="emailSubject" placeholder="Titel..." required><br><br>
				Bericht<br>
				<textarea name="emailMessage" id="emailMessage" rows="10" cols="55" placeholder="Uw bericht..." required></textarea>
				<input type="submit" name="emailSubmit">
			</form>
			<?php
				if($misc->readVar('POST', 'emailSubmit') && isset($_POST['userEmail']) && isset($_POST['emailSubject']) && isset($_POST['emailMessage']
				)){
					$misc->sendMail($_POST['userEmail'], $_POST['emailSubject'], $_POST['emailMessage']);
				}
			?>
		</div>
		<div class="w3-col l3 hidden">
			ree
		</div>
		<div class="w3-col l5">
			Wilt u meer informatie over de Zevensprong of wilt u een afspraak maken? U kunt ons bereiken per telefoon of per email:<br><br>
			<table>
				<tr>
					<th>Bezoekadres:</th>
					<td class="hidden">ree</td>
					<th>Postadres:</th>
				</tr>
				<tr>
					<td>Straatnaam 00</td>
					<td class="hidden">ree</td>
					<td>Postbus 123</td>
				</tr>
				<tr>
					<td>1234 AB</td>
					<td class="hidden">ree</td>
					<td>post adres</td>
				</tr>
			</table>
			<br>
			<br>
			<b>T: </b> 1234 - 56 78 91
			<b>@: </b> dezevensprong@hotmail.com
			<img src="images/placeholder.png" class="image">
		</div>
	</div>
</body>
</html>