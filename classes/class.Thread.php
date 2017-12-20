<?php
// Specify timezone for correct time insert in database
date_default_timezone_set('Europe/Amsterdam');

	class Thread
	{
		protected $db;
		private $thread_id;
		private $user_id;

		// Db connection
		public function __construct()
		{
			$this->db = new Database();
			$this->user_id = $_SESSION['user_ID'];
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
				echo 'Your thread has been posted.';
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