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
    }
?>