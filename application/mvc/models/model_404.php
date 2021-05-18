<?php
    class Model_404 extends Model{
        public function get_data(){
            global $CFG;
            return array(
                "SEPARATOR" => $CFG->getCFGValue("dir_separator"),
                "TITLE" => "Страница не найдена."
            );
        }
    }
?>