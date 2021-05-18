<?php
    class Controller_Documentation extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Documentation();
        }
        
        public function run($subactions = null){
            View::generate_view('documentation_view.php', 'template_view.php', $this->MODEL->get_data(), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
        }
    }
?>