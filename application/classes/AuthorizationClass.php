<?php
class Authorization {

        # Класс для работы с базой данных.
        private $DBWorker = NULL;

        function __construct(){
            $this->DBWorker = new DatabaseWorker(true);    
        }

        function __destruct() {
            $this->DBWorker->close_connection();
        }

        static function isHaveRequeiredCookie(){
            # Проверка cookie-пользователей
            if(!isset($_COOKIE['AUTH_TOKEN']) || !isset($_COOKIE['USER_EMAIL'])){
                return false;
            }
            else {
                return true;
            }
        }

        function Authorization($email, $paswd, $rememberMe){
            $query = $this->DBWorker->get_query("get-paswd");
            $result = $this->DBWorker->query($query, "with-prepare", ["email" => $email]);

            if(gettype($result) == "boolean" && $result) {
                return false;
            }
            
            $crypt_method = $result[0]['crypt_method'] ? $result[0]['crypt_method'] : "";
            $salt = $result[0]['salt'] ? $result[0]['salt'] : "";
            $crypting_paswd = $result[0]['crypting_password'];

            $paswd = Authorization::cryptPasswordByRule($paswd, $crypt_method, $salt);

            if($crypting_paswd == $paswd) {
                $timelife_cookie = $rememberMe ?  time() + 604800 /* Семь дней */: time() + 3600 /* Один час */;
                $auth_token = Authorization::createAuthToken($email);

                setcookie("AUTH_TOKEN", $auth_token, $timelife_cookie);
                setcookie("USER_EMAIL", $email, $timelife_cookie);

                return true;
            }
            else {
                return false;
            }
        }

        static function cryptPasswordByRule($paswd, $rule, $salt){
            if($rule){
                switch($rule) {
                    case "sha1": $paswd = sha1($paswd); break;
                    case "sha1/salt/md5": $paswd = sha1($salt . md5( $paswd )); break;
                }
            }
            return $paswd;
        }

        static function isAuthorization(){
            $auth_token = isset($_COOKIE['AUTH_TOKEN']) ? $_COOKIE['AUTH_TOKEN'] : "";
            $email = isset($_COOKIE['USER_EMAIL']) ? $_COOKIE['USER_EMAIL'] : "_";
            
            $result = Authorization::isHaveRequeiredCookie() && Authorization::validateAuthToken($auth_token, $email);

            if($result){
                global $CFG;
                $user_id = Authorization::getUserId();
                if($user_id){
                    $CFG->setCFGValue("user_id", Authorization::getUserId());
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }

        static private function createAuthToken($d){
            return strtoupper(mb_substr(sha1(md5($d) . "/" . sha1($d)), 2, 10));
        }

        static public function validateAuthToken($d, $e){
            return $d == self::createAuthToken($e);
        }

        public function getAccessGrantsByEmail(){
            $result_query = $this->DBWorker->query(
                "SELECT type FROM users u JOIN users_metadata um ON u.userID = um.userID AND um.metakey = 'email' AND um.metavalue = :email;",
                "with-prepare",
                ["email" => isset($_COOKIE['USER_EMAIL']) ? $_COOKIE['USER_EMAIL'] : ""]
            );
            return $result_query ? $result_query[0] : null;
        }

        public function getAccessGrantsById($id){
            $result_query = $this->DBWorker->query(
                "SELECT type FROM users WHERE users.userId = :id;",
                "with-prepare",
                ["id" => $id]
            );
            return $result_query ? $result_query[0] : null;
        }

        static function getUserId(){
            $conn = new DatabaseWorker(true);
            $result_query = $conn->query(
                "SELECT userId FROM users_metadata um WHERE um.metakey = 'email' AND um.metavalue = :email;", 
                "with-prepare", 
                ["email" => $_COOKIE['USER_EMAIL']]
            );
            $conn->close_connection();
            return $result_query ? $result_query[0]["userId"] : null;
        }
    }
?>