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
                $user = new User($_SESSION['user_ID']); 
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
                echo '<a class="thread" href="class?class_id='.$res['class_ID'].'">'.$res['Name'].'</a><br/>';
            }
        }

        public function getAllStudentsInClass($ID)
        {
            $check = false;
            $user = new User();
            if($user->loginCheck())
            {
                $sth = $this->db->selectDatabase('students', 'class_ID', $_GET['class_id'], '');
                while($row = $sth->fetch())
                {
                    $sth2 = $this->db->selectDatabase('users', 'user_ID', $row['user_ID'], '');
                    $row2 = $sth2->fetch();
                    if($user->permission > 1)
                    {
                        echo '<form action="class?class_id='.$_GET['class_id'].'" method="POST" style="position: relative;display: inline;left: -6px;"><input type="hidden" name="user_ID" value="'.$row['user_ID'].'"><input type="submit" name="remStudentFromClass" value="X" class="w3-btn" style="color: #F1EEEF;background-color: #C2000D;position: relative;height: 41px;opacity: 0.5;border: none;border-bottom: 2px solid #A30005;border-radius: 5px;" title="Verwijder student van klas"></form>';
                    }
                    echo '<a class="thread" href="account?user_id='.$row['user_ID'].'">'.$row2['Firstname'] .'&nbsp;'.$row2['Lastname'].'</a><br/>';
                    $check = true;
                }
            }
            if(!$check)
            {
                echo '<div style="color: #6B6B6B;">Er zitten geen studenten in deze klas</div>';
            }
        }

        public function dropdownClassList()
        {
            $teacherQuery = $this->db->selectDatabase('teachers','user_ID',$_SESSION['user_ID'],'');
            $teacherResult = $teacherQuery->fetch();

            $sth = $this->db->selectDatabase('class', '','','');
            $result = $sth->fetchAll();

            echo '<select name="classList">';
            foreach($result as $class)
            {
                if($class['class_ID'] == $teacherResult['class_ID'])
                {
                    echo '<option selected value="'.$class['class_ID'].'">'.$class['Name'].'</option>';
                }
                else echo '<option value="'.$class['class_ID'].'">'.$class['Name'].'</option>';
            }
            echo '</select>';
        }

        /**
         * @param  ID The ID of the file
         * @return File data from database
         */
        public function getUploadDetails($ID)
        {
            $sth = $this->db->selectDatabase('upload', 'upload_ID', $ID,'');
            if($file = $sth->fetch())
            {
                return $file;
            }
            else return false;
        }
    }
?>