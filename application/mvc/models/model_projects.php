<?php
    class Model_Projects extends Model{
        public function get_data(){}

        public function get_data_by_id($id){
            $system_information = [
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Заказ на проект #$id",
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "main",
                "PROJECT_ID" => $id
            ];

            $project = ["project" => $this->get_information_about_project_by_id($id)];
            $stages = ["stages" => $this->get_information_about_stages_by_id($id)];
            $client = ["client" => $this->get_information_about_client_by_id($id)];
            
            return array_merge($system_information, $project, $stages, $client);
        }

        public function get_stages_page($id){
            $system_information = [
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Стадии проекта #$id",
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "main",
                "PROJECT_ID" => $id
            ];
            $stages = $this->get_information_about_stages_by_id($id);


            return array_merge($system_information, $stages);
        }

        public function get_client_page($id){
            $system_information = [
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Клиент проекта #$id",
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "main",
                "PROJECT_ID" => $id
            ];

            $client = $this->get_information_about_client_by_id($id);
            return array_merge($system_information, $client, ["is_edit" => isset($_GET['edit']) && isset($client) && $_GET['edit'] == "on"]);
        }

        public function save_client_information($client, $id){
            $clientDB = $this->get_information_about_client_by_id($id);

            if(isset($clientDB['client'])) {

            }
            else {
                # Добавление основной информации о клиенте.
                $client_id = $clientDB['client_id'];
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'name', :val);", "with-prepare", ['val' => $client['clientName']]);
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'surname', :val);", "with-prepare", ['val' => $client['clientSurname']]);
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'middlename', :val);", "with-prepare", ['val' => $client['clientMiddlename']]);
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'date_born', :val);", "with-prepare", ['val' => $client['clientDateBorn']]);
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'email', :val);", "with-prepare", ['val' => $client['clientEmail']]);
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'phone', :val);", "with-prepare", ['val' => $client['clientPhone']]);
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'types', :val);", "with-prepare", ['val' => $clientDB['clientType']]);

                # Добавление данных о паспорте клиента.
                $this->DbConnection->query(
                    "INSERT INTO passports (serial, number, date_get, who_get) VALUES (:serial, :number, :date_get, :who_get);",
                    "with-prepare",
                    [
                        "serial" => intval($client["clientPassportSerial"]),
                        "number" => intval($client["clientPassportNumber"]),
                        "date_get" => $client["clientPassportDateGet"],
                        "who_get" => $client["clientPassportWhoGet"]
                    ]
                );
                $passport_id = $this->DbConnection->get_last_id();
                $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'passport_id', :val);", "with-prepare", ['val' => $passport_id]);

                # Добавление информации о счёте клиента.
                if($clientDB['clientType'] == "client-physical") {
                    $this->DbConnection->query(
                        "INSERT INTO cards (card_number, card_lost, card_name) VALUES (:cardNumber, :cardLost, :cardName);",
                        "with-prepare",
                        [
                            "cardNumber" => $client["clientCardNumber"],
                            "cardLost" => $client["clientCardLostDate"],
                            "cardName" => $client["clientCardName"]
                        ]
                    );
                    $card_id = $this->DbConnection->get_last_id();
                    $this->DbConnection->query("INSERT INTO users_metadata (userID, metakey, metavalue) VALUES ($client_id, 'card_id', :val);", "with-prepare", ['val' => $card_id]);

                } else if($clientDB['clientType'] == "client-legal") {

                }
            }
        }

        private function get_information_about_project_by_id($id){
            $this->DbConnection->query("SET @current_date = CAST(CURRENT_TIMESTAMP AS DATE);");
            $result_query_project = $this->DbConnection->query(
                "SELECT project_name, project_about, deadline, full_cost, is_inarchive,
                    CASE WHEN @current_date < deadline THEN 'is-active'
                        WHEN @current_date = deadline AND is_inarchive = 0 THEN 'surrender-today'
                        WHEN is_inarchive = 1 THEN 'is-completed'
                        ELSE 'is-losted'
                    END as project_status
                FROM projects WHERE projectID = :id LIMIT 0, 1;",
                "with-prepare",
                ["id" => $id]
            );
            $_separator = $this->CFG->getCFGValue("dir_separator");
            $result_query_file = $this->DbConnection->query(
                "SELECT file_src, file_name, file_ext FROM mmdocumentsandproject mm JOIN files f ON mm.projectID = :projectID AND f.fileID = mm.fileID AND f.file_about = \"technical-task\";",
                "with-prepare",
                ["projectID" => $id]
            );

            return $result_query_project && $result_query_file ? array_merge($result_query_project[0], ["technical_task" => $result_query_file[0]['file_src'] . $_separator . $result_query_file[0]['file_name'] . '.' . $result_query_file[0]['file_ext'] ]) : null;
        }

        private function get_information_about_stages_by_id($id){
            $this->DbConnection->query("SET @current_date = CAST(CURRENT_TIMESTAMP AS DATE);");
            $result_query = $this->DbConnection->query(
                "SELECT *,
                    CASE WHEN @current_date < deadline THEN 'is-active'
                        WHEN @current_date = deadline AND is_inarchive = 0 THEN 'surrender-today'
                        WHEN is_inarchive = 1 THEN 'is-completed'
                        ELSE 'is-losted'
                    END as stage_status
                FROM stages s WHERE s.projectId = :id;",
                "with-prepare",
                ["id" => $id]
            );

            $buffer = [];
            if($result_query){
                foreach($result_query as $row){
                    $buffer[] = [
                        "stage_name" => $row['stage_name'],
                        "stage_about" => $row['stage_about'],
                        "stage_cost" => $row['stage_cost'],
                        "stage_link_github" => $row['stage_link_github'],
                        "deadline" => $row['deadline'],
                        "executor_role" => $row['executorRole'],
                        "executor_id" => $row['executorId'],
                        "stage_status" => $row['stage_status']
                    ];
                }
            }
            return $buffer;
        }

        private function get_information_about_client_by_id($id){
            $result_client_id = $this->DbConnection->query(
                "SELECT p.clientID FROM projects p WHERE projectID = :id",
                "with-prepare",
                ["id" => $id]
            );
            
            if($result_client_id) {
                $this->DbConnection->query(
                    "SET @client_id = :clientID;",
                    "with-prepare",
                    ["clientID" => $result_client_id[0]["clientID"]]
                );
                $result_query_metadata = $this->DbConnection->query("SELECT metakey, metavalue FROM users_metadata um WHERE um.userId = @client_id;", "fetch-all");
                $result_query_client = $this->DbConnection->query(
                    "SELECT u.type from users u WHERE userID = (SELECT p.clientID FROM projects p WHERE projectID = :projectID)",
                    "with-prepare",
                    ["projectID" => $id]
                );
    
                $buffer_metadata = null;
                if($result_query_metadata) {
                    $buffer_metadata = [];
                    foreach($result_query_metadata as $row){
                        $buffer_metadata[$row['metakey']] = $row['metavalue'];
                    }
                }
                return ["client" => $buffer_metadata, "clientType" => $result_query_client ? $result_query_client[0]['type'] : null, "client_id" => $result_client_id[0]['clientID']];
            }
            else {
                return [];
            }
        }
    }
?>