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
        	$sth = $this->db->selectDatabase('thread','thread_id',$thread_ID,'');
			if($row = $sth->fetch())
			{
				$user = new User($_SESSION['Username']); 
            	$user_ID = $user->id;
            	// Not yet implemented: 
            	$userRights = $user->userRights;

            	if($row['user_ID'] == $user_ID)
            	{
            		// Thread belongs to logged in user
            		return true;
            	}
            	elseif($userRights == '2') // Or whatever 
            	{
            		// Logged in user is teacher
            		return true;
            	}
            	else
            	{
            		return false;
            	}

			} 
        }

		public function editThread()
		{
			if(validateUserRights($thread_ID))
			{
				throw new Exception('Not implemented');	
			}
			
		}
	}
?>