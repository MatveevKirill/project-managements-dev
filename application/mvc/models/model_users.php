<?php
    class Model_Users extends Model{
        public function get_data(){
            $system_information = array(
                "SEPARATOR" => $this->CFG->getCFGValue("dir_separator"),
                "TITLE" => "Пользователи",
                "ROOT_PATH" => $this->CFG->getCFGValue("root_path"),
                "ALLOWED_ACCESS" => Authorization::isAuthorization(),
                "ALLOWED_INMENU" => "users",
                "ACTION" => isset($_GET['act']) ? $_GET['act'] : "all"
            );

            $users = $this->get_users();

            return array_merge($system_information, $users);
        }

        private function get_users(){
            return [
                "administrators" => $this->get_persons(),
                "clients" => $this->get_clients()
            ];
        }

        private function get_clients(){
            $result_query = $this->DbConnection->query("SELECT u.userID, metakey, metavalue FROM users u JOIN users_metadata um ON u.userID = um.userID AND u.type LIKE '%client%';");
            $userID = null;
            $buffer = [];

            foreach($result_query as $row){
                if(!$userID || $userID != $row['userID']){
                    $userID = $row['userID'];
                    $buffer[$row['userID']] = [];
                }
                else if($userID == $row['userID']){
                    $buffer[$row['userID']][$row['metakey']] = $row['metavalue'];
                }
            }
            

            return $result_query ? $buffer : [];
        }

        private function get_persons(){
            $result_query = $this->DbConnection->query("SELECT u.userID, metakey, metavalue FROM users u JOIN users_metadata um ON u.userID = um.userID AND u.type LIKE '%administrator%';");
            $userID = null;
            $buffer = [];

            foreach($result_query as $row){
                if(!$userID || $userID != $row['userID']){
                    $userID = $row['userID'];
                    $buffer[$row['userID']][$row['metakey']] = $row['metavalue'];
                }
                else if($userID == $row['userID']){
                    $buffer[$row['userID']][$row['metakey']] = $row['metavalue'];
                }
            }

            return $result_query ? $buffer : [];
        }
    }
?>