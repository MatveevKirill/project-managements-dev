<?php
    class Controller_Main extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Main();
            $this->VIEW = new View();
        }
        
        public function run($subactions = null){

            if(isset($_GET['act']) && $_GET['act'] == "add"){
                if(count($_REQUEST) == 6){
                    $project_id = $this->MODEL->create_project(array_merge($_REQUEST, ["fileInfo" => $_FILES["technicalTask"]]));
                    return $project_id ? header("Location: /projects/" . $project_id) : header('Location: /500');
                }
                else {
                    View::generate_view('main_addorder_view.php', 'template_view.php', $this->MODEL->order_worker(), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
                }
            }
            else {
                View::generate_view('main_view.php', 'template_view.php', $this->MODEL->get_data(), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
            }
        }
    }
?>