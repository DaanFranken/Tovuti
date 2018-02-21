<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/home.css">
</head>
<body>
<div class="container">
	<div class="w3-row">
		<div class="w3-col l3">
			
			<h3 class="title">Verwachtingen</h3>
			<p class="text">
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. 
			</p>
		</div>
		<div class="w3-col l3">
			<h3 class="title">Onderwijs</h3>
			<p class="text">
			Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. 
			</p>
		</div>
		<div class="w3-col l3">
			<h3 class="title">Opvang</h3>
			<p class="text">
			Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestibulum volutpat pretium libero. Cras id dui. Aenean ut eros et nisl sagittis vestibulum. Nullam nulla eros, ultricies sit amet, nonummy id, imperdiet feugiat, pede. Sed lectus. Donec mollis hendrerit risus. Phasellus nec sem in justo pellentesque facilisis. Etiam imperdiet imperdiet orci. Nunc nec neque. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. 
			</p>
		</div>
		<div class="w3-col l3">
			<h3 class="title">Locatie</h3>
			<p class="text">
			Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Maecenas malesuada. Praesent congue erat at massa. Sed cursus turpis vitae tortor. Donec posuere vulputate arcu. Phasellus accumsan cursus velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed aliquam, nisi quis porttitor congue, elit erat euismod orci, ac placerat dolor lectus quis orci. Phasellus consectetuer vestibulum elit. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. 
			</p>
		</div>
	</div>
	<div class="w3-row floatingText">
		<div class="w3-col l4">
		<h4 class="infoTitle">
			Het laatste nieuws
		</h4>
		<div class="nieuwsText">
			<?php
				$sth = $db->selectDatabase('thread', '', '', '');
				while($row = $sth->fetch())
				{
					$sth2 = $db->selectDatabase('students', 'user_ID', $row['user_ID'], '');
					if($row2 = $sth2->fetch())
					{
						$klas = $row2['class_ID'];
					}
					else
					{
						$sth2 = $db->selectDatabase('teachers', 'user_ID', $row['user_ID'], '');
						if($row2 = $sth2->fetch())
						{
							$klas = $row2['class_ID'];
						}
					}
					if(empty($klas))
					{
						$klas = '';
					}
					else
					{
						$sth2 = $db->selectDatabase('class', 'class_ID', $klas, '');
						$row2 = $sth2->fetch();
						$klas = $row2['Name'];
					}
					if($user->loginCheck())
					{
						echo '<a href="forum?thread_id='.$row['thread_ID'].'">';
					}
					echo '<ul style="border:none;">'.$klas.' | '. $row['threadDate'].' | '. $row['Title'].'</ul>';
					if($user->loginCheck())
					{
						echo '</a>';
					}
				}
			?>
		</div>
		</div>
		<div class="w3-col l4 hidden">
		deze tekst die hier staat is eigenlijk best wel nutteloos, ik heb geen idee waarom je dit leest want dit stukje tekst doet echt helemaal niks. het komt niet eens op de website te staan. nou niks is een groot woord. er moet iets in deze div staan anders is de layout van de webpagina niet goed. maar verder heb ik geen idee waarom ik dit stukje tekst er überhaupt in heb gezet.
		</div>
		<div class="w3-col l4 zevensprongInformatie">
			<h3 class="infoTitle">de Zevensprong</h3>
			<p class="w3-center">
			de Zevensprong biedt kinderopvang, tussen- en naschoolse opvang en basisonderwijs.
			</p>
		</div>
	</div>
	<div class="w3-row">
		<div class="w3-col l4">
			<h4 class="infoTitle">
				Vacatures
			</h4>
			<p class="vacatureText">
				De Zevensprong zoekt pedagogische medewerkers.
			</p>
			<a href="#">Lees meer</a>
		</div>
		<div class="w3-col l8 hidden">
		deze tekst die hier staat is eigenlijk best wel nutteloos, ik heb geen idee waarom je dit leest want dit stukje tekst doet echt helemaal niks. het komt niet eens op de website te staan. nou niks is een groot woord. er moet iets in deze div staan anders is de layout van de webpagina niet goed. maar verder heb ik geen idee waarom ik dit stukje tekst er überhaupt in heb gezet.
		</div>
	</div>
</div>
</body>
</html>