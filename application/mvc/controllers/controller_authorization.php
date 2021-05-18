<?php
    class Controller_Authorization extends Controller {
        function __construct()
        {
            $this->MODEL = new Model_Authorization();
        }
        
        public function run($subactions = null){
            $authorization_status = $this->authorization_status();
            $_ERROR = null;

            switch($authorization_status){
                case "yes-access": header("Location: /"); break;
                case "error-authorization": $_ERROR = ["code" => 500, "desc" => "Произошла внутренняя ошибка сервера при авторизации."]; break;
                case "wrong-data": $_ERROR = ["code" => 403, "desc" => "Введены некорректные данные для входа."]; break;
                case "no-access"; $_ERROR = null; break;
                default: break;
            }

            $send_data = $this->MODEL->get_data();
            $scripts = [["place" => "before", "type" => "css", "src" => "static/css/signin.css"]];
            View::generate_view('authorization_view.php', 'template_view.php', $send_data, $scripts, $_ERROR);
        }

        private function authorization_status(){
            if(
                isset($_POST['authInputEmail']) && mb_strlen($_POST['authInputEmail']) > 0 &&
                isset($_POST['authInputPassword']) && mb_strlen($_POST['authInputPassword']) > 0
                ){
                try{
                    $auth = new Authorization();
                    if($auth->Authorization($_POST['authInputEmail'], $_POST['authInputPassword'], isset($_POST['authRememberMe']) && $_POST['authRememberMe'] == "yes-remember" ? true : false)){
                        return "yes-access";
                    }
                    else {
                        return "wrong-data";
                    }
                }
                catch(Exception $e){
                    return "error-authorization";
                }
            }
            else {
                return "no-access";  
            }
        }
    }
?>