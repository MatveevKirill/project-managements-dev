<?php
    class Model_Main extends Model{
        
        public function get_data(){
            $system_information = array(
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Заказы проектов",
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "main",
                "ACTION" => isset($_GET['act']) ? $_GET['act'] : "all"
            );

            $projects = $this->get_projects();

            if($projects){
                $system_information['orders'] = $projects;
                return $system_information;
            }
            else {
                return $system_information;
            }
        }

        public function order_worker(){
            $system_information = array(
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Добавить проект",
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "main",
                "ACTION" => isset($_GET['act']) ? $_GET['act'] : "all"
            );

            $executor = $this->get_exexucot_by_email(isset($_COOKIE['USER_EMAIL']) ? $_COOKIE['USER_EMAIL'] : "nullptr");

            return array_merge($system_information, $executor);
        }

        public function create_project($project){
            # Добавление данных о пользователе
            $client_type = $project['clientType'] == "physical" ? "client-physical" : "client-legal";
            $this->DbConnection->query(
                "INSERT INTO users (type) VALUES (:clientType);",
                "with-prepare",
                ["clientType" => $client_type]
            );
            
            # Получение идентфикаторов клиента и исполнителя
            $client_id = $this->DbConnection->get_last_id();
            $executor_id = $this->CFG->getCFGValue("user_id");

            # Добавление данных по проекту
            $this->DbConnection->query(
                "INSERT INTO projects (clientID, executorID, project_name, project_about, deadline, full_cost) VALUES (:clientID, :executorID, :projectName, :projectAbout, :deadline, :fullCost);",
                "with-prepare",
                [
                    "clientID" => $client_id, 
                    "executorID" => $executor_id,
                    "projectName" => $project['projectName'],
                    "projectAbout" => $project['projectAbout'],
                    "deadline" => $project['projectDeadline'],
                    "fullCost" => $project['projectFullCost']
                ]
            );
            $project_id = $this->DbConnection->get_last_id();

            # Добавление файла ТЗ в систему
            $_separator = $this->CFG->getCFGValue("dir_separator");
            $fileName = md5(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 16));
            $fileExt = explode('.', $project['fileInfo']['name'])[count(explode(".", $project['fileInfo']['name'])) - 1];
            $fileAbout = "technical-task";
            $fileSrc = $_separator . "static" . $_separator . "filemanager";
            $fileSize = $project['fileInfo']['size'];
            $this->DbConnection->query(
                "INSERT INTO files (file_name, file_about, file_src, file_ext, file_size) VALUES (:fileName, :fileAbout, :fileSrc, :fileExt, :fileSize);",
                "with-prepare",
                [
                    "fileName" => $fileName,
                    "fileAbout" => $fileAbout,
                    "fileSrc" => $fileSrc,
                    "fileExt" => $fileExt,
                    "fileSize" => $fileSize
                ]
            );
            move_uploaded_file($project['fileInfo']['tmp_name'], $this->CFG->getCFGValue("root_path") . $fileSrc . $_separator . $fileName . "." . $fileExt);

            # Добавление в таблицу связь М-М
            $file_id = $this->DbConnection->get_last_id();
            $this->DbConnection->query(
                "INSERT INTO mmdocumentsandproject (projectID, fileID) VALUES (:projectID, :fileID);",
                "with-prepare",
                [
                    "projectID" => $project_id,
                    "fileID" => $file_id
                ]
            );

            return $project_id;
        }

        private function get_projects(){
            $result_query = $this->DbConnection->query("SELECT * FROM projects;");
            $buffer = [];
            if($result_query){
                foreach($result_query as $row){
                    $executor = $this->get_executor($row["executorID"]);
                    $status = $this->get_status_about_order($row['projectID']);
                    $count_stages = $this->get_count_stages($row['projectID']);
    
                    $buffer[] = array_merge($row, $executor, $status, $count_stages);
                }
            }
            return $buffer;
        }

        private function get_exexucot_by_email($email){
            $result_query = $this->DbConnection->query(
                "SELECT metakey, metavalue FROM users_metadata um WHERE (um.metakey = 'name' OR um.metakey = 'surname' OR um.metakey = 'middlename') AND um.userID = (SELECT umi.userID FROM users_metadata umi WHERE umi.metakey = 'email' AND umi.metavalue = :email);",
                "with-prepare",
                ["email" => $email]    
            );
            
            $buffer = [];
            if($result_query) {
                foreach($result_query as $row){
                    $buffer[$row['metakey']] = $row['metavalue'];
                }
            }

            return $buffer;
        }
        
        private function get_executor($id){
            $result_query = $this->DbConnection->query(
                "SELECT metakey, metavalue FROM users_metadata um WHERE um.userID = :userId AND (um.metakey = 'name' OR um.metakey = 'surname' OR um.metakey = 'middlename');",
                "with-prepare",
                ["userId" => $id]    
            );

            if($result_query){
                $buffer = [];
                foreach($result_query as $row){
                    $buffer[$row['metakey']] = $row['metavalue'];
                }
                return $buffer;
            }
            else {
                return null;
            }
        }

        private function get_status_about_order($id){
            $this->DbConnection->query("SET @current_date = CAST(CURRENT_TIMESTAMP AS DATE);");
            $result_query = $this->DbConnection->query(
                "SELECT CASE WHEN @current_date < deadline THEN 'is-active'
                    WHEN @current_date = deadline AND is_inarchive = 0 THEN 'surrender-today'
                    WHEN is_inarchive = 1 THEN 'is-completed'
                    ELSE 'is-losted'
                    END as is_deadline
                FROM projects WHERE projects.projectID = :id;
                ",
                "with-prepare",
                ["id" => $id]
            );
            
            return $result_query ? ["status" => $result_query[0]['is_deadline']] : ["status" => "<Не установлено>"];

        }

        private function get_count_stages($id) {
            $result_query = $this->DbConnection->query(
                "SELECT COUNT(*) as count FROM stages WHERE projectID = :id;",
                "with-prepare",
                ["id" => $id]
            );
            return $result_query ? ["count_stages" => $result_query[0]['count']] : ["count_stages" => 0];
        }
    }
?>