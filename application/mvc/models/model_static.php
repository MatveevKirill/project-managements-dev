<?php
    class Model_Static extends Model{
        public function get_data(){
            return array(
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "ROOT_PATH" => $this->CFG->getCFGValue("root_path")
            );
        }
    }
?>