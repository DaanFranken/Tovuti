<?php
// Specify timezone for correct time insert in database
date_default_timezone_set('Europe/Amsterdam');

	class Thread
	{
		public $thread_id;
		protected $db;
		public $user_id;
		public $title;
		public $thread;
		public $threadDate;

		// Db connection
		public function __construct($thread_id = NULL)
		{
			$this->db = new Database();
			$this->user_id = $_SESSION['user_ID'];

			if(!empty($thread_id))
			{
				$sth = $this->db->selectDatabase('thread', 'thread_ID', $thread_id, '');
				if($row = $sth->fetch())
				{
					$this->thread_id 	=	$row['thread_ID'];
					$this->user_id 		=	$row['user_ID'];
					$this->title 		= 	$row['Title'];
					$this->thread 		=	$row['Thread'];
					$this->threadDate 	=	$row['threadDate'];
				}
			}

		}

		public function getThread($thread_ID)
		{
			$sth = $this->db->selectDatabase('thread','thread_id',$thread_ID,'');
			if($row = $sth->fetch())
			{
				
			}			
		}

		public function getAllThreads()
		{
			$addon = ' ORDER BY Urgency DESC';
			$sth = $this->db->selectDatabase('thread','','',$addon);
			$result = $sth->fetchAll();
			echo '<ul class="w3-ul w3-card-4">';
			foreach($result as $res)
			{
				$urgency = $res['Urgency'];
				?>
				    <li class="w3-bar">
				    <?php
				    	switch ($urgency) {
				    		case '0':
				    			echo '<i class="fa fa-sticky-note fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; color:#000000;"></i>';
				    			break;

			    			case '1':
			    			echo '<i class="fa fa-exclamation-triangle fa-3x w3-bar-item w3-circle w3-hide-small" aria-hidden="true" style="width:85px; color:#cc0000;"></i>';
			    			break;
				    		
				    		default:
				    			# code...
				    			break;
				    	}

				    ?>
					    

					      
					      <div class="w3-bar-item">
					        <span class="w3-large"><?php echo '<a href="?pageStr=thread&thread_id='.$res['thread_ID'] . '">' . $res['Title'] . '</a>'; ?></span><br>
					        <span><?php echo $res['Thread'];?></span>
					      </div>
					    </li>


				<?php
			}
		}

		public function createThread($user_ID, $title, $thread)
		{
			$user = new User();
			$user->getUserByID($this->user_id);
			
			if($user->permission != 0)
			{
				$arrayValues['thread_ID'] 	= trim(com_create_guid(), '{}');
				$arrayValues['user_ID']		= $user_ID;
				$arrayValues['Title'] 		= $title;
				$arrayValues['Thread']		= $thread;
				$arrayValues['threadDate']	= date("Y-m-d H:i:s");

				$this->db->insertDatabase('thread', $arrayValues);
				echo 'Uw bericht is geplaatst';
			}
		}

		public function editThread()
		{
			$misc = new Misc();
			if($misc->validateUserRights($thread_ID))
			{
				// Permission to edit thread
			}
			else
			{
				// No permission to edit thread
			}
		}
	}
?>