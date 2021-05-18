<?php
    class Controller_Signout extends Controller {
        public function run($subactions = null){
            if(isset($_COOKIE['AUTH_TOKEN'])){
                setcookie("AUTH_TOKEN", "");
            }

            if(isset($_COOKIE['USER_EMAIL'])) {
                setcookie("USER_EMAIL", "");
            }

            header("Location: /");
        }
    }
?>