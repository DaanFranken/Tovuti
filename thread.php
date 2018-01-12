<?php
if($user->loginCheck())
{
	$check = false;
	?>
	<div class="w3-margin">
		<?php

		// Creat new thread
		if(isset($_POST['createNewThread']))
		{
			$check = true;
			if($misc->readVar('POST', 'createNewThread') && isset($_POST['newThread']))
			{
				$title = str_replace("<","&lt;",$_POST['title']);
				$threadPost = str_replace("<","&lt;",$_POST['thread']);
				$urgency = str_replace("<","&lt;",$_POST['urgency']);
				$thread->createThread($user->id, $title, $threadPost, $urgency);
				?>
				<script>
					setTimeout(function(){
						window.location.href = 'index.php?pageStr=forum';
					}, 2000);
				</script>
				<?php
			}
			else
			{
				$thread->newThreadForm(false);
			}
		}

		// Edit thread
		if(isset($_GET['editThread']) || isset($_POST['editThread']))
		{
			$check = true;
			if($misc->readVar('POST', 'editThread') && isset($_POST['newThread']))
			{
				$arrayValues['Title'] 		= str_replace("<","&lt;",$_POST['title']);
				$arrayValues['Thread']		= str_replace("<","&lt;",$_POST['thread']);
				$arrayValues['Urgency']		= str_replace("<","&lt;",$_POST['urgency']);
				$arrayValues['lastChanged']	= date("Y-m-d H:i:s");

				$db->updateDatabase('thread', 'thread_ID', $_POST['threadID'], $arrayValues, '');
				echo 'Uw post is succesvol aangepast';
				?>
				<script>
					setTimeout(function(){
						window.location.href = 'index.php?pageStr=forum';
					}, 2000);
				</script>
				<?php
			}
			else
			{
				$sth = $db->selectDatabase('thread', 'thread_ID', $_GET['editThread'], '');
				$thread->newThreadForm($sth);
			}
		}

		// Edit reaction
		if(isset($_POST['changeEditedReaction']))
		{
			$editReaction = str_replace('<', '&lt;', $_POST['editedReaction']);
			$arrayValues['Reaction'] = $editReaction;
			$arrayValues['lastChanged'] = date('Y-m-d H:i:s');
			$db->updateDatabase('reaction', 'reaction_ID', $_POST['editedReactionID'], $arrayValues, '');
			echo '<script>window.location.href = "?pageStr=forum&thread_id='.$_POST['thread_ID'].'";</script>';
		}

		// Delete reaction
		if(isset($_POST['deleteReply']))
		{
			$arrayValues['Status'] = 0;
			$db->updateDatabase('reaction', 'reaction_ID', $_POST['reactionID'], $arrayValues, '');
			echo '<script>window.location.href = "?pageStr=forum&thread_id='.$_POST['thread_ID'].'";</script>';
		}

		// Display threads
		if(!$check)
		{
			if(empty($misc->readVar('GET','thread_id')))
			{
				$thread = new Thread();
				if(!isset($_GET['user_id']))
				{
					$thread->getAllThreads();	
				}
				elseif($misc->readVar('GET','user_id'))
				{
					$thread->getAllThreads($_GET['user_id']);
				}			
			}
			else
			{
				echo '<a class="thread" href="?pageStr=forum">Terug naar forum</a>';
				$thread = new Thread($misc->readVar('GET','thread_id'));
				echo '<h3>'.$thread->title.'</h3>';
				echo $thread->thread;
				echo '<hr/>';
				$thread->getThreadReplies($thread->thread_id);
				?>


				<form method="POST" id="reply">
					<div class="w3-row w3-section">
						<div class="w3-col" style="width:50px; color:#2C9AC9!important;"><i class="w3-xxlarge fa fa-pencil"></i></div>
						<div class="w3-rest">
							<textarea class="w3-input w3-border" style="width: 98%;" name="comment" form="reply" placeholder="Schrijf hier uw reactie"></textarea>
						</div>
					</div>

					<input type="submit" name="sendReply" value="Reageer" class="w3-btn w3-margin" style="color: white;background-color: #89D162;border-bottom: 2px solid #58B327;">
				</form>
				<?php
			}
		}

		// New reaction
		if($misc->readVar('POST','sendReply'))
		{
			$Reaction = str_replace('<', '&lt;', $_POST['comment']);
			$arrayValues['reaction_ID'] 	= $misc->getGUID();
			$arrayValues['thread_ID'] 		= $thread->thread_id;
			$arrayValues['user_ID'] 		= $user->id;
			$arrayValues['Reaction'] 		= $Reaction;
			$arrayValues['reactionDate'] 	= date("Y-m-d H:i:s");
			$db->insertDatabase('reaction',$arrayValues);
			echo '<script>window.location.href = "?pageStr=forum&thread_id='.$thread->thread_id.'";</script>';
		}

		// Delete thread | Alleen docenten en admins kunnen posts verwijderen
		if($misc->readVar('POST','threadID') && $user->permission > 1 && !isset($_POST['editThread']))
		{
			$thread->deleteThread($_POST['threadID']);
			echo '<script>window.location.href = "index.php?pageStr=forum";</script>';
		}

		?>
	</div>
	<?php
	if(!$check && !isset($_GET['thread_id']))
	{
		?>
		<form action="" method="POST">
			<input type="submit" name="createNewThread" value="+" class="w3-button w3-circle w3-teal w3-right w3-medium w3-margin w3-card-4">
		</form>
		<?php
	}
	?>
	<script>
		function deleteThread(threadID){
			if(confirm("Weet u zeker dat u deze post wil verwijderen?")){
				document.getElementById('deleteForm'+threadID).submit();
			}
		}
	</script>
	<?php
}
else
{
	echo 'U dient in te loggen om deze pagina te bekijken';
}
?>