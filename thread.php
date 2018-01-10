<?php
if($user->loginCheck())
{
	$check = false;
	?>
	<div class="w3-margin">
		<?php

		// Delete thread | Alleen docenten en admins kunnen posts verwijderen
		if($misc->readVar('POST','threadID') && $user->permission > 1)
		{
			$thread->deleteThread($_POST['threadID']);
			?>
			<script>
			window.location.href = 'index.php?pageStr=forum';
			</script>
			<?php
		}

		// Creat new thread
		if(isset($_POST['createNewThread']))
		{
			$check = true;
			if($misc->readVar('POST', 'createNewThread') && $misc->readVar('POST', 'createNewThread') && isset($_POST['newThread']))
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
			if(isset($_POST['createNewThreadTrue']))
			{
				$title = str_replace("<","&lt;",$_POST['title']);
				$threadPost = str_replace("<","&lt;",$_POST['thread']);
				$urgency = str_replace("<","&lt;",$_POST['urgency']);
				$thread->editThread($_POST['threadID'], $title, $thread, $urgency, date("Y-m-d H:i:s"))
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
			}
		}

		?>
	</div>
	<?php
	if(!$check)
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