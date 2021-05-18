<?php
    require_once("./config.php");
    
    require_once("./application/classes/DatabaseWorkerClass.php");
    require_once("./application/classes/AuthorizationClass.php");

    require_once("./application/mvc/bootstrap-mvc.php");
    Router::run();
?>