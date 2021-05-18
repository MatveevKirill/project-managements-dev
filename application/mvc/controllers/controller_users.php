<?php
    class Controller_Users extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Users();
        }
        
        public function run($subactions = null){
            View::generate_view('users_view.php', 'template_view.php', $this->MODEL->get_data(), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
        }
    }
?>