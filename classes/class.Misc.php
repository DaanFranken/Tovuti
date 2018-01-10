<?php
    // Helper class used for a variety of support functions
    class Misc 
    {
        protected $db;

        // Db connection
        public function __construct()
        {
            $this->db = new Database();
        }

        public function readVar($type, $var) 
        {
            if($type == 'POST')
            {
                if (isset($_POST[$var]) && !empty($_POST[$var]))
                {
                    return $_POST[$var];
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                if (isset($_GET[$var]) && !empty($_GET[$var]))
                {
                    return $_GET[$var];
                    return true;
                }
                else
                {
                    return false;
                }
            }         
        }

        public function validateUserRights($thread_ID)
        {
            $sth = $this->db->selectDatabase('thread','thread_id',$thread_ID,'');
            if($row = $sth->fetch())
            {
                $user = new User($_SESSION['Username']); 
                $user_ID = $user->id;
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

        // Highlight menu button of current page
        public function menuCurrentPage($pageStr, $currentPage)
        {
            if($pageStr == $currentPage)
            {
                echo 'style="height: calc(100% + 2px);border-bottom: 2px solid #333333;box-shadow: 0px -5px 10px #6aaef5;"';
            }
        }
    }
?>