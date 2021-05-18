<?php
    class Controller_Profile extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Profile();
        }
        
        public function run($subactions = null){
            $user_id = isset($subactions[1]) ? intval($subactions[1]) : 0;
            if($user_id) {
                View::generate_view('profile_view.php', 'template_view.php', $this->MODEL->get_data_by_id($user_id), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
            }
            else {
                header("Location: /");
            }
        }
    }
?>