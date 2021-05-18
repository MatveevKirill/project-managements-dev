<?php
    class Config{  
        /*
            @ Classname: ConfigBaseClass.
            @ AboutClass: класс для работы с глобальными параметрами приложения.
        */

        # Глобальные настройки приложения.
        private $CFG = array();

        # Параметра глобальной конфигурации, которые запрещено менять.
        private $PRIVATE_CFG_KEYS = array("root_path", "dir_separator", "version", "release", "debug", "htaccess_path", "host_name", "database_connection");
        
        public function __construct(){
            // Основной каталог приложения.
            $this->CFG['root_path'] = $_SERVER['DOCUMENT_ROOT'];

            // Разделитель между каталогами в зависимости от типа ОС.
            $this->CFG['dir_separator'] = DIRECTORY_SEPARATOR;

            // Подключаем версию приложения.
            require_once($this->CFG['root_path'] . $this->CFG['dir_separator'] . 'version.php');

            // Устанавливаем версию в настройки.
            $this->CFG['version'] = $version;

            // Устанавливаем релиз в настройки.
            $this->CFG['release'] = $release;

            // Устанавливаем Debug mode.
            $this->CFG['debug'] = true;

            // Устанавливаем путь до файла .htaccess.
            $this->CFG['htaccess_path'] = $this->CFG['root_path'] . $this->CFG['dir_separator'] . '.htaccess';

            // Устанавливаем название хоста
            $this->CFG['host_name'] = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/';
        
            // Устанавливаем подключение к базе данных
            $this->CFG['database_connection'] = array(
                "host" => "localhost",
                "username" => "root",
                "password" => "",
                "database" => "devex",
                "charset" => "utf8"
            );
        }

        public function __destruct(){
            // Удаляем все данные о настрйках.
            unset($this->CFG);
        }

        public function setCFGValue($key, $value){
            /*
                @ Methodname:  setCFGValue.
                @ Methodabout: установить настройки в глобальную переменную.
                @ Params:
                    @param: $key - ключ, по которому устанавливается значение;
                    @param: $value - значение, которое устанавливается по ключу.
                @ ErrorExept:  если данного ключ уже существует, то действие отменится и 
                в файл логов будет занесена ошибка при создании глобальной конфигурации.
                @ RetValue: (bool): true - успешно установилось значение, false - неуспешно установилось значение.
            */
            if(in_array($key, $this->PRIVATE_CFG_KEYS)){
                if($this->CFG['debug']){
                    throw new Exception("ConfigBaseClass.setCFGValue(): попытка перезаписать запрещённый параметр '" . $key . "' глобальной конфигурации.");
                }
                else {
                    # Логирование ошибки в файл Log'ов.

                    return false;
                }
            }
            else {
                $this->CFG[$key] = $value;
                return true;
            }
        }

        public function getCFGValue($key) {
            /*
                @ Methodname:  getCFGValue.
                @ Methodabout: получить настройки из глобальной переменной по ключу.
                @ Params:
                    @param: $key - ключ, по которому берётся значение;
                @ ErrorExept:  если данного ключа не существует, то действие отменится и 
                в файл логов будет занесена ошибка при создании глобальной конфигурации.
                @ RetValue: ($CFG[$key] | null): null - неудачное получение ключа с ошибкой, $CFG[$key] - полученное значение.
            */
            
            if(isset($this->CFG[$key])){
                return $this->CFG[$key];
            }
            else {
                if($this->CFG['debug']){
                    throw new Exception("ConfigBaseClass.getCFGValue(): попытка получить несуществующий ключ '$key' из глобальных настроек.");
                }
                else {
                    # Логирование ошибки в файл Log'ов.

                    return null;
                }
            }
        }

        public function deleteCFGValue($key){
            /*
                @ Methodname:  deleteCFGValue.
                @ Methodabout: удалить настройки из глобальной переменной по ключу.
                @ Params:
                    @param: $key - ключ, по которому удаляется значение;
                @ ErrorExept:  если данный ключа не существует, то действие отменится и 
                в файл логов будет занесена ошибка при удалении глобальной конфигурации.
                @ RetValue: (bool): true - удачное удаление, false - неудачное или с ошибкой удаление.
            */
            if(in_array($key, $this->PRIVATE_CFG_KEYS)){
                if($this->CFG['debug']){
                    throw new Exception("ConfigBaseClass.deleteCFGValue(): попытка удалить запрещённый параметр '" . $key . "' глобальной конфигурации.");
                }
                else {
                    # Запись в лог файлы.

                    return false;
                }
            }
            else if(isset($this->CFG[$key])){
                unset($this->CFG[$key]);
                return true;
            }
            else {
                if($this->CFG['debug']){
                    throw new Exception("ConfigBaseClass.deleteCFGValue(): ошибка при удалении параметра глобальной конфигурации. Ключа не существует для удаления.");
                }
                else {
                    # Запись в лог файлы.

                    return false;
                }
            }
        }

        public function resetCFGValue($key, $value){
            /*
                @ Methodname:  resetCFGValue.
                @ Methodabout: переустановить значение по ключу.
                @ Params:
                    @param: $key - ключ, по которому переустанавливается значение;
                @ ErrorExept:  если данный ключа не существует, то действие отменится и 
                в файл логов будет занесена ошибка при переустановке глобальной конфигурации.
                @ RetValue: (bool): true - успешно переустановилось значение, false - неуспешно переустановилось.
            */
            if(in_array($key, $this->PRIVATE_CFG_KEYS)){
                if($this->CFG['debug']) {
                    throw new Exception("ConfigBaseClass.resetCFGValue(): попытка перезаписать запрещённый параметр '" . $key . "' глобальной конфигурации.");
                }
                else {
                    # Запись в лог файлы.

                    return false;
                }
            }
            else if(isset($this->CFG[$key])){
                $this->CFG[$key] = $value;
                return true;
            }
            else {
                if($this->CFG['debug']){
                    throw new Exception("ConfigBaseClass.resetCFGValue(): ошибка при переустановки параметра глобальной конфигурации.");
                }
                else {
                    # Запись в лог файлы.

                    return false;
                }
            }
        }
    }
?>