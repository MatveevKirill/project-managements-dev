<?php
    class Controller_Projects extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Projects();
        }
        
        public function run($subactions = null){
            

            if(count($subactions) > 1){
                $project = $this->MODEL->get_data_by_id($subactions[1]);
                if($project['project']){
                    switch(count($subactions)){
                        case 2: View::generate_view('projects_view.php', 'template_view.php', $project, [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]); break;
                        case 3: 
                            switch($subactions[2]){
                                case "client": 
                                    if(count($_POST) > 0) {
                                        $this->MODEL->save_client_information($_POST, $subactions[1]);
                                        header("Location: /");
                                    }

                                    View::generate_view('projects_client_view.php', 'template_view.php', $this->MODEL->get_client_page($subactions[1]), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]); 
                                    break;
                                case "stages": View::generate_view('projects_stages_view.php', 'template_view.php', $this->MODEL->get_stages_page($subactions[1]), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]); break;
                                default: header("Location: /404");
                            }
                            break;
                        default: header("Location: /404");
                    }
                }
                else {
                    header("Location: /404");      
                }
            }
            else {
                header("Location: /");
            }
        }
    }
?>