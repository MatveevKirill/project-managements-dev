<?php
    class Model_Profile extends Model{
        public function get_data_by_id($id) {
            $system_information = [
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Профиль",
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "profile"
            ];

            $profile_information = $this->get_profile_data($id);

            # Если получен не null-ответ, то соединяем массивы.
            if($profile_information){
                # Объединение в один общий массив
                $buffer = array();
                foreach($profile_information as $row){
                    $buffer[$row['metakey']] = $row['metavalue'];
                }

                # Проверка прав доступа к системе
                $auth = new Authorization();
                $grants = $auth->getAccessGrantsById($id);

                # Получение информации по проектам пользователя
                $projects = $this->get_user_projects();

                return array_change_key_case(array_merge($system_information, $buffer, $grants, $projects), CASE_UPPER);
            }
            else {
                header("Location: /");
            }
        }
        
        public function get_data(){}

        private function get_profile_data($id){        
            $result_query = $this->DbConnection->query(
                "SELECT metakey, metavalue FROM users_metadata um WHERE um.userID = :id AND um.metakey != 'paswd_id' AND um.metakey != 'email';",
                "with-prepare",
                ["id" => $id]
            );
            return $result_query ? $result_query : null;
        }

        private function get_user_projects(){
            $this->DbConnection->query(
                "SET @user_id = (SELECT userID from users_metadata um WHERE um.metakey = 'email' AND um.metavalue = :email)",
                "with-prepare",
                ["email" => isset($_COOKIE['USER_EMAIL']) ? $_COOKIE['USER_EMAIL'] : null]
            );
            
            $buffer = [
                "manager" => [],
                "stages" => []
            ];
            
            $result_query_manager = $this->DbConnection->query("SELECT projectId, project_name, deadline, full_cost FROM projects WHERE executorID = @user_id;");
            $result_query_stages = $this->DbConnection->query("SELECT projectId, stage_name, executorRole, deadline, stage_cost FROM stages WHERE executorID = @user_id;");
            

            if($result_query_manager) {
                foreach($result_query_manager as $row){
                    $buffer['manager'][$row['projectId']]['project_name'] = $row['project_name'];
                    $buffer['manager'][$row['projectId']]['deadline'] = $row['deadline'];
                    $buffer['manager'][$row['projectId']]['full_cost'] = $row['full_cost'];
                }
            }

            if($result_query_stages) {
                foreach($result_query_stages as $row){
                    $buffer['stages'][$row['projectId']]['stage_name'] = $row['stage_name'];
                    $buffer['stages'][$row['projectId']]['executorRole'] = $row['executorRole'];
                    $buffer['stages'][$row['projectId']]['deadline'] = $row['deadline'];
                    $buffer['stages'][$row['projectId']]['stage_cost'] = $row['stage_cost'];
                }
            }

            return $buffer;
        }
    }
?>