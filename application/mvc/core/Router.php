<?php
    class Router{
        static function run(){            
            // Загружаем глобальные настройки.
            global $CFG;

            // Получаем разделитель для папок в зависимости от ОС.
            $SEPARATOR = $CFG->getCFGValue("dir_separator");
            
            // Контроллер и роутер по умолчанию.
            $controller_name = "authorization";
            $default_controller_name = "main";

            // Полный список маршрутизации.
            $all_routes = array_slice(explode("/", explode("?", $_SERVER['REQUEST_URI'])[0]), 1);
            
            // Записываем полученный контроллер.
            if(!empty($all_routes[0])){
                $controller_name = $all_routes[0];
            }
            
            if(Router::BreakRouters($all_routes[0]) || Router::SkipRouters($all_routes[0])){
                exit;
            }
            
            // Проверка на существование контроллера
            if(!Router::ControllerExists($controller_name)){
                Router::Error404();
            }

            // Проверка на авторизацию пользователя.
            if(Authorization::isAuthorization() && !Router::HasError()){
                if((!Router::ControllerExists($controller_name) || $controller_name == "authorization") && Authorization::isAuthorization()){
                    $controller_name = $default_controller_name;
                }
            }


            // Добавляем префиксы.
            $model_name = "Model_" . $controller_name;
            $controller_name = "Controller_" . $controller_name;
            

            // Название с файлом модели.
            $model_file = strtolower($model_name . '.php');
            $model_path = "application" . $SEPARATOR ."mvc" . $SEPARATOR . "models" . $SEPARATOR . $model_file;

            if(file_exists($model_path)){
                include $model_path;
            }
            

            // Название с файлом контроллера.
            $controller_file = strtolower($controller_name . '.php');
            $controller_path = "application" . $SEPARATOR . "mvc" . $SEPARATOR . "controllers" . $SEPARATOR . $controller_file;

            if(file_exists($controller_path)){
                include $controller_path;
            }
            else {
                // Вызов ошибки 404.
                Router::Error404();
            }

            // Создаём контроллер
            $controller = new $controller_name;
            
            $controller->run($all_routes);
        }

        static function Error404(){
            if(Router::HasError()) return;
            global $CFG;

            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
            header('Location: ' . $CFG->getCFGValue("host_name") . "404");
        }

        static function Error500($code = ""){
            if(Router::HasError()) return;
            global $CFG;

            header('HTTP/1.1 500 Internal Server Error');
            header('Status: 500 Internal Server Error');
            header('Location: ' . $CFG->getCFGValue("host_name") . "500" . ($code != "" ? "?code=" .$code : ""));
        }

        static function HasError(){
            switch(explode("/", explode("?", $_SERVER['REQUEST_URI'])[0])[1]){
                case "404": case "500": return true;
                default: return false;
            }
        }

        static function BreakRouters($page){
            $page_list = ["favicon.ico"];
            
            return in_array($page, $page_list);
        }

        static function SkipRouters($page){
            $page_list = ["api"];

            return in_array($page, $page_list);
        }

        static function Redirect($url = ""){
            global $CFG;
            
            header("Location: " . $CFG->getCFGValue("host_name") . $url);
        }

        static function ControllerExists($controller_name){
            global $CFG;
            $SEPARATOR = $CFG->getCFGValue("dir_separator");

            // Название с файлом контроллера.
            $controller_name = "Controller_" . $controller_name;
            $controller_file = strtolower($controller_name . '.php');
            $controller_path = "application" . $SEPARATOR . "mvc" . $SEPARATOR . "controllers" . $SEPARATOR . $controller_file;

            return file_exists($controller_path);
        }
    }
?>