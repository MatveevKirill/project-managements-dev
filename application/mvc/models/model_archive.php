<?php
    class Model_Archive extends Model{
        public function get_data(){
            global $CFG;
            return array(
                "SEPARATOR" => $CFG->getCFGValue("dir_separator"),
                "TITLE" => "Архив",
                "ROOT_PATH" => $CFG->getCFGValue("root_path"),
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "archive"
            );
        }
    }
?>