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

	?>
</div>