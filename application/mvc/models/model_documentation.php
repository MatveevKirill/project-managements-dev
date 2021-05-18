<?php
    class Model_Documentation extends Model{
        public function get_data(){
            global $CFG;
            return array(
                "SEPARATOR" => $CFG->getCFGValue("dir_separator"),
                "TITLE" => "Документация",
                "ROOT_PATH" => $CFG->getCFGValue("root_path"),
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "documentation"
            );
        }
    }
?>