<?php
    class Controller_Archive extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Archive();
        }
        
        public function run($subactions = null){
            View::generate_view('archive_view.php', 'template_view.php', $this->MODEL->get_data(), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
        }
    }
?>