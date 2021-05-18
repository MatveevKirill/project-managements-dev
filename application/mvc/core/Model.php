<?php
    abstract class Model{
        protected $DbConnection;
        protected $CFG;
        
        function __construct() {
            global $CFG;
            $this->CFG = $CFG;

            $this->DbConnection = new DatabaseWorker();
            $this->DbConnection->connection();
        }

        function __destruct() {
            $this->DbConnection->close_connection();
        }

        abstract protected function get_data();
    }
?>