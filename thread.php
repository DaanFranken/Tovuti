<div class="w3-margin">

	<?php
	if($misc->readVar('GET','deleteThread'))
	{
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
			$thread->getAllThreads();
		}
		else
		{
			echo '<a href="?pageStr=thread">Back to topic list</a>';
			$thread = new Thread($misc->readVar('GET','thread_id'));
			echo '<h3>'.$thread->title.'</h3>';
			echo $thread->thread;
		}
	}
	else echo 'U dient in te loggen om deze pagina te bekijken';

	?>
</div>