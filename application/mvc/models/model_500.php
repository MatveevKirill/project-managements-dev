<?php
    class Model_500 extends Model{
        public function get_data(){
            global $CFG;
            return array(
                "SEPARATOR" => $CFG->getCFGValue("dir_separator"),
                "TITLE" => "Произошла ошибка на сервере.",
                "ERROR_CODE" => $this->get_error_desc_by_code()
            );
        }

        private function get_error_desc_by_code(){
            $code = isset($_GET['code']) ? $_GET['code'] : "";
            $descs = [
                [
                    "code" => "apierr-not-allowed-apiversion",
                    "desc" => "Не найдена версия API."
                ],
                [
                    "code" => "apierr-badquery",
                    "desc" => "Неверный запрос к API."
                ],
                [
                    "code" => "apierr-cant-find-apimethod",
                    "desc" => "Не найден метод глобального класса."
                ]
            ];

            foreach($descs as $desc) {
                if(in_array($code, $desc)){
                    return $desc['desc'];
                }
            }
            return "Произошла непредвиденная ошибка на сервере.";
        }
    }
?>