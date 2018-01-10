<div class="w3-margin">
	<?php

	// Alleen docenten en admins kunnen posts verwijderen
	if($misc->readVar('GET','deleteThread') && $user->permission > 1)
	{
		echo '<script>alert("Weet u zeker dat u deze post wil verwijderen?");</script>';
		$thread_id = $_GET['deleteThread'];
		$updateArray['Status'] = 0;
		echo 'De thread is verwijderd. U keert automatisch terug.';
		if($db->updateDatabase('thread','thread_ID',$thread_id,$updateArray))
		{		
			
		}
		?>
		<script>
			setTimeout(function(){
				window.location.href = 'index.php?pageStr=thread';
			}, 2000);
		</script>
		<?php

	}

	// Creat new thread
	$check = false;
	if(isset($_POST['createNewThread']))
	{
		$check = true;
		if($misc->readVar('POST', 'createNewThread') && $misc->readVar('POST', 'createNewThread') && $misc->readVar('POST', 'createNewThread') && isset($_POST['newThread']))
		{
			$title = $_POST['title'];
			$thread = $_POST['thread'];
			$misc->createThread($user->id, $title, $thread);
		}
		else
		{
			newThreadForm();
		}
	}

	function newThreadForm()
	{
		?>
		<form action="" method="POST">
				<label class="w3-text-teal"><b>Title</b></label>
				<input type="text" name="title" <?php echo (isset($_POST['newThread'])) ? 'value="'.$_POST['title'].'"' : 'placeholder="Title"'; ?> class="w3-input w3-border w3-light-grey">
				<label class="w3-text-teal"><b>Thread</b></label>
				<input type="text" name="thread" <?php echo (isset($_POST['newThread'])) ? 'value="'.$_POST['thread'].'"' : 'placeholder="Thread"'; ?> class="w3-input w3-border w3-light-grey">
				<input type="submit" name="newThread" value="Save">
			</form>
		<?php
	}

	// Display threads
	if(!$check)
	{
		if($user->loginCheck())
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
				echo '<a class="thread" href="?pageStr=thread">Terug naar forum</a>';
				$thread = new Thread($misc->readVar('GET','thread_id'));
				echo '<h3>'.$thread->title.'</h3>';
				echo $thread->thread;
			}
		}
		else echo 'U dient in te loggen om deze pagina te bekijken';
	}

	?>
</div>
<form action="" method="POST">
	<input type="submit" name="createNewThread" value="+" class="w3-button w3-circle w3-teal w3-right w3-medium w3-margin w3-card-4">
</form>