<?php
    class Controller_Invoice extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Invoice();
        }
        
        public function run($subactions = null){
            if(isset($_POST['projectID'])){
                header("Location: /invoice/" . $_POST['projectID']);
            }

            if(count($subactions) == 2){
                View::generate_view('invoice_view.php', 'template_view.php', $this->MODEL->generate_invoice($subactions[1]), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
            }
            else {
                View::generate_view('invoice_select_view.php', 'template_view.php', $this->MODEL->select_invoice(), [["place" => "before", "type" => "css", "src" => "static/css/dashboard.css"]]);
            }
        }
    }
?>