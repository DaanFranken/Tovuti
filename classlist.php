<?php
if($misc->readVar('GET','class_id'))
{
	$sth = $db->selectDatabase('class','class_ID',$_GET['class_id'],'');
	$result = $sth->fetch();
}

?>

<div class="w3-container w3-margin">
	<?php 
	if($misc->readVar('GET','class_id'))
	{
		echo '<a class="thread" href="?pageStr=class">Terug naar klassen overzicht</a>';
	}
	?>
	<div class="w3-card-4 w3-rest">
		<header class="w3-container w3-light-grey">
			<h3><?php echo 'Klassenlijst '. (isset($_GET['class_id']) ? $result['Name'] : '');   ?></h3>
		</header>
		<div class="w3-container">
			<p>
				<?php
				if(!$misc->readVar('GET','class_id'))
				{
					$misc->getAllClassesAsList();	
				}
				else
				{
					$misc->getAllStudentsInClass($_GET['class_id']);
				}			

				?></p>
				<hr>
			</div>
		</div>
	</div>