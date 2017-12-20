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

		public function validateUserRights($thread_ID)
        {
        	$sth = $this->db->selectDatabase('thread','thread_id',$thread_ID,'');
			if($row = $sth->fetch())
			{
				$user = new User($_SESSION['Username']); 
            	$user_ID = $user->id;
            	// Not yet implemented: 
            	$permission = $user->permission;

            	if($row['user_ID'] == $user_ID)
            	{
            		// Thread belongs to logged in user
            		return true;
            	}
            	elseif($permission == '2' || $permission == '3') 
            	{
            		// Logged in user is teacher or admin
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
			else
			{
				// No permission to edit thread
			}
		}
	}
?>