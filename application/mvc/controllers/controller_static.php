<?php
    class Controller_Static extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Static();
        }
        
        public function run($subactions = null){
            // Получаем данные из модели.
            $data = $this->MODEL->get_data();

            // Проверяем на допустимые типы: 'css' или 'js'.
            switch($subactions[1]){                
                case "css": $data['content_type'] = "text/css"; break;
                case "js": $data['content_type'] = "application/javascript"; break;
                default: Router::Error404();
            }

            $data['full_path'] = $data['ROOT_PATH'] . $data['SEPARATOR'] . implode($data['SEPARATOR'], array("static", implode($data['SEPARATOR'], $subactions)));
            if(file_exists($data['full_path'])){
                View::generate_view('', 'static_view.php', $data);
            }
            else {
                Router::Error404();
            }
        }
    }
?>