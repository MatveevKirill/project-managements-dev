<?php
    class Model_Invoice extends Model{
        public function get_data(){}

        public function select_invoice(){
            $system_information = array(
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Выбор счёт-фактуры",
                "ROOT_PATH" => $this->CFG->getCFGValue("root_path"),
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "invoice"
            );

            $all_invoices = ["invoices" => $this->get_all_invoices()];
            return array_merge($system_information, $all_invoices);
        }

        public function generate_invoice($id){
            $system_information = [
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Создание счёт-фактуры",
                "ROOT_PATH" => $this->CFG->getCFGValue("root_path"),
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "invoice"
            ];

            $stages = $this->get_stages($id);
            $project = $this->get_project($id);


            return array_merge($system_information, $stages, $project);
        }

        private function get_all_invoices(){
            $result_query = $this->DbConnection->query("SELECT projectID, project_name FROM projects;");
            $buffer = [];

            if($result_query){
                foreach($result_query as $row){
                    $buffer[] = [
                        'projectID' => $row['projectID'],
                        'project_name' => $row['project_name']
                    ];
                }
            }

            return $result_query ? $buffer : [];
        }

        private function get_stages($id){
            $all_stages = $this->DbConnection->query(
                "SELECT s.stageID, s.stage_name, s.stage_cost, s.executorRole, s.deadline, GROUP_CONCAT(um.metavalue SEPARATOR ' ') as executorName FROM stages s LEFT JOIN users_metadata um ON s.projectId = :id AND s.executorId = um.userID AND (um.metakey = 'surname' OR um.metakey = 'name');",
                "with-prepare",
                ["id" => $id]
            );

            $full_cost = 0;

            if($all_stages){
                foreach($all_stages as $stage){
                    $full_cost += $stage['stage_cost'];
                }
            }

            return $all_stages ? array_merge(['stages' => $all_stages], ['full_cost' => $full_cost]) : [];
        }

        private function get_project($id){
            $project = $this->DbConnection->query(
                "SELECT * FROM projects WHERE projectID = :id;",
                "with-prepare",
                ["id" => $id]
            );

            $client = $this->DbConnection->query(
                "SELECT um.metakey, um.metavalue FROM users_metadata um WHERE um.userID = (SELECT p.clientID FROM projects p WHERE p.projectID = :id);",
                "with-prepare",
                ["id" => $id]
            );

            $buffer_client = [];
            if($client) {
                foreach($client as $data){
                    $buffer_client[$data['metakey']] = $data['metavalue'];
                }
            }

            
            return $project && count($project) > 0? array_merge(["project" => $project[0]], ["client" => $buffer_client]) : [];
        }
    }
?>