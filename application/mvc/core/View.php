<?php
    class View{
        public static function generate_view($content_view, $template_view, $_DATA = null, $src_static_files = null, $_ERROR = null){
            // Если массив, то распаковываем все данные.
            if(is_array($_DATA)){
                extract(array_change_key_case($_DATA, CASE_UPPER));
                unset($_DATA);
            }

            include 'application' . $SEPARATOR . 'mvc' . $SEPARATOR . 'views' . $SEPARATOR . $template_view;
        }
    }
?>