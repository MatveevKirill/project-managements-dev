<?php
    class Controller_404 extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_404();
            $this->VIEW = new View();
        }
        
        public function run($subactions = null){
            View::generate_view('404_view.php', 'template_view.php', $this->MODEL->get_data());
        }
    }
?>