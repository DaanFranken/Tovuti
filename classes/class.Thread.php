<?php
// Specify timezone for correct time insert in database
date_default_timezone_set('Europe/Amsterdam');

	class Thread
	{
		public $thread_id;
		protected $db;
		public $user_id;
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
			throw new Exception('Not implemented');
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