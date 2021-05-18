<?php
    class Model_Authorization extends Model{
        public function get_data(){
            global $CFG;
            return array(
                "SEPARATOR" => $CFG->getCFGValue("dir_separator"),
                "TITLE" => "Авторизация",
                "HOST_NAME" => $CFG->getCFGValue("host_name")
            );
        }
    }
?>