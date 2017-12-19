<?php
	class Thread
	{
		protected $db;
		private $thread_id;
		private $user_id;

		// Db connection
		public function __construct()
		{
			$this->db = new Database();
		}

		public function getThread($thread_ID)
		{
			$sth = $this->db->selectDatabase('thread','thread_id',$thread_ID,'');
			if($row = $sth->fetch())
			{
				$this->thread_id 	= $row['thread_ID'];
				$this->user_id 		= $row['user_ID'];
				return true;
			}			
		}

		public function getAllThreads()
		{
			throw new Exception('Not implemented');
		}

		public function createThread()
		{
			throw new Exception('Not implemented');
		}

		public function validateUserRights($thread_ID)
        {
            $user = new User($_SESSION['Username']); 
            $user_ID = $user->id;

            // Not yet implemented
            $userRights = $user->userRights;
            

        }

		public function editThread()
		{
			if(validateUserRights())
			{
				throw new Exception('Not implemented');	
			}
			
		}
	}
?>