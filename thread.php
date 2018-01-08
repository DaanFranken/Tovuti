<div class="w3-margin">

<?php
if(isset($_SESSION['user_ID']))
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
else echo 'Log eerst ff in pik';

?>
</div>