<?php
    class DatabaseWorker {
        
        # Данные о подключении к базе данных.
        private $ConfigConnection = NULL;
        private $Connection = NULL;
        private $DebugMode = false;
        
        function __construct($auto_connection = false){
            global $CFG;
            $this->DebugMode = $CFG->getCFGValue('debug');

            # Устанавливаем локальные настройки для подключения к базе данных из глобальной конфигурации.
            $this->ConfigConnection = $CFG->getCFGValue("database_connection");

            if($auto_connection){
                $this->connection();
            }
        }

        function __destruct(){
            $this->close_connection();
        }

        function connection(){
            if(
                isset($this->ConfigConnection['host']) && 
                isset($this->ConfigConnection['username']) && 
                isset($this->ConfigConnection['password']) && 
                isset($this->ConfigConnection['database']) &&
                isset($this->ConfigConnection['charset'])
            ){
                try {
                    $this->Connection = new PDO(
                        'mysql:host=' . $this->ConfigConnection['host'] . ';dbname=' . $this->ConfigConnection['database'] . ";charset=" . $this->ConfigConnection['charset'], 
                        $this->ConfigConnection['username'],
                        $this->ConfigConnection['password'],
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false
                        ]
                    );
                }
                catch(PDOException $e) {
                    if($this->DebugMode) {
                        throw new Exception("Не создано подключение к базе данных '" . $this->ConfigConnection['database'] . "': " . $e->getMessage());
                    }
                }
            }
            else {
                if($this->DebugMode){
                    throw new Exception("Не создано подключение к базе данных '" . $this->ConfigConnection['database'] . "': не переданы данные для подключения.");
                }
            }
        }

        function close_connection(){
            if($this->Connection){
                $this->Connection = null;
            }
        }
        
        function query($query, $type = "default", $query_params = null, $return_param = null){
            if($this->Connection){
                try{
                    $result_query = null;

                    if($query_params && $type == "with-prepare"){
                        $prepare = $this->Connection->prepare($query);
                        $prepare->execute($query_params);
                        $result = $prepare->fetchAll();
                        return count($result) > 0 ? $result : null;
                    }
                    else if(!$query_params && $type == "fetch-one"){
                        $result_query = $this->Connection->query($query)->fetch();
                    }
                    else{
                        $result_query = $this->Connection->query($query)->fetchAll();                        
                    }
                    
                    return $result_query;
                }
                catch(PDOException $e){
                    if($this->DebugMode){
                        throw new PDOException("Произошла ошибка во время выполнения пользовательского запроса: " . $e->getMessage());
                    }
                }
            }
            else {
                if($this->DebugMode){
                    throw new Exception("Не создано подключение к базе данных '" . $this->ConfigConnection['database'] . "'.");
                }
            }
        }

        function get_query($query_id){           
            switch($query_id){
                case "get-paswd": return "SELECT * FROM users_metadata um JOIN passwords ps ON um.userID = (SELECT userID FROM users_metadata um WHERE um.metakey = 'email' AND um.metavalue = :email) AND um.metakey = 'paswd_id';";
                default: return null;
            }
        }

        function get_last_id(){
            return $this->Connection ? $this->Connection->lastInsertId() : null;
        }
    }
?>