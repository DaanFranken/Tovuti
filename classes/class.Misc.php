<?php
    // Helper class used for a variety of support functions
    class Misc {
        public function readVar($type, $var) 
        {
            if($type == 'POST')
            {
                if (isset($_POST[$var]) && !empty($_POST[$var]))
                {
                    return $_POST[$var];
                }
            }
            else
            {
                if (isset($_GET[$var]) && !empty($_GET[$var]))
                {
                    return $_GET[$var];
                }
            }         
        }
        
        public function readGetVar($fieldname) {
            if (!empty($_GET)) {
                if (isset($_GET[$fieldname]) && !empty($_GET[$fieldname])) {
                    return $_GET[$fieldname];
                } else {
                    return NULL;
                }
            }
        }
        
        public function readPostVar($fieldname) {
            if (isset($_POST[$fieldname])) {
                return $_POST[$fieldname];
            } else {
                return NULL;
            }
        }
        
        public function readGetVarAndCheckIfItsTrue($fieldname) {
            if (isset($_GET[$fieldname]) && $_GET[$fieldname] == 1) {
                return $_GET[$fieldname];
            }
        }
        
        public function checkIfUserIsLoggedIn() {
            if ($this->readVar($_SESSION['firstname']) === NULL || $this->readVar($_SESSION['surname']) === NULL && $this->readVar($_SESSION['isLoggedIn']) === NULL) {
                header("Location: login.php");
            }
        }
        
    }
