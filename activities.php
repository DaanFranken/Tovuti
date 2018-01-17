<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>	
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<style>
.nicEdit-main
{
	height: 400px;
	width: 100%;
}  
</style>
<?php
$sth = $db->selectDatabase('activities','','','');
$result = $sth->fetch();


if($user->loginCheck())
{
	?>
	<div class="w3-container w3-margin">
		<div class="w3-card-4 w3-rest" style="height:100%;min-height: 550px;">
			<header class="w3-container w3-light-grey">
				<h3>Activiteiten</h3>
			</header>
			<div class="w3-container">
				<!-- Edit rights: -->
				<?php if($user->permission > 1)
				{
					?>
					<form method="POST">
					<textarea name="pagecontent" style="width: 100%;">
       					<?php echo $result['Content']; ?>
		        	</textarea>	
		        	<input type="submit" name="activitySubmit" value="Sla pagina op" class="w3-btn w3-margin" style="color: white;background-color: #89D162;border-bottom: 2px solid #58B327;">
		        	</form>
					<?php
					if($misc->readVar('POST','pagecontent'))
					{
						$content = $_POST['pagecontent'];
						$arrayValues['user_ID'] = $user->id;
						$arrayValues['Content'] = htmlspecialchars($content);
						$arrayValues['editDate'] = date("Y-m-d H:i:s");

						$db->updateDatabase('activities', '', '', $arrayValues, '');
						echo '<script>window.location.href = "?pageStr=activities";</script>';
					}
				}
				// No edit rights:
				else
				{
					?>
					<div style="width: 100%; height:400px;">
       					<?php echo html_entity_decode($result['Content']); ?>
		        	</div>	
					<?php
				}
				?>									
			</div>
		</div>
	</div>
<?php
}
else echo 'U dient in te loggen om deze pagina te bekijken';
?>
