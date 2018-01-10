<?php
    // Helper class used for a variety of support functions
    class Misc 
    {
        protected $db;
        protected $user;

        // Db connection
        public function __construct()
        {
            $this->db = new Database();
            $this->user = new User();
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

        // Create rand ID
        public function getGUID()
        {
            if (function_exists('com_create_guid')){
                return trim(com_create_guid(), '{}');
            }
            else {
                mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
                $charid = strtoupper(md5(uniqid(rand(), true)));
                $hyphen = chr(45);// "-"
                $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
                return trim($uuid, '{}');
            }
        }

        public function getAllClassesAsList()
        {
            $sth = $this->db->selectDatabase('class', '','','');
            $result = $sth->fetchAll();

            foreach($result as $res)
            {
                echo '<a class="thread" href="?pageStr=class&class_id='.$res['class_ID'].'">'.$res['Name'].'</a>';
            }
        }

        public function getAllStudentsInClass($ID)
        {
            $sth = $this->db->selectDatabase('students', 'class_ID',$ID,'');
            $result = $sth->fetchAll();

            foreach($result as $res)
            {
                $user = new User();
                $user->getUserByID($res['user_ID']);

                echo '<a class="thread" href="?pageStr=account&user_id='.$user->id.'">'.$user->firstname .'&nbsp;'.$user->lastname.'</a><br/>';
            }
        }
    }
?>