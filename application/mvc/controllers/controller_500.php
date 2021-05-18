<?php
    class Controller_500 extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_500();
            $this->VIEW = new View();
        }
        
        public function run($subactions = null){
            View::generate_view('500_view.php', 'template_view.php', $this->MODEL->get_data());
        }
    }
?>