<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8" />
        <title><?=(isset($TITLE) ? $TITLE . " | КОНТЕКС" : "КОНТЕКС");?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css" />
        <?php
            if(isset($src_static_files)) {
                foreach($src_static_files as $static_element){
                    if(isset($static_element['type']) && isset($static_element['src']) && isset($static_element['place']) && $static_element['place'] == "before"){
                        switch($static_element['type']){
                            case "css":
                                ?>
                                <link rel="stylesheet" type="text/css" href="/<?=$static_element['src']?>" />
                                <?php
                            break;
                            case "js":
                                ?>
                                <script type="application/javascript" src="/<?=$static_element['src']?>"></script>
                                <?php
                            break;
                            default: break;
                        }
                    }
                }
            }
        ?>
    </head>
    <body>
        <?php
            require_once "application" . $SEPARATOR . "mvc" . $SEPARATOR . "views" . $SEPARATOR . "header_view.php";
            require_once "application" . $SEPARATOR . "mvc" . $SEPARATOR . "views" . $SEPARATOR . $content_view;
            require_once "application" . $SEPARATOR . "mvc" . $SEPARATOR . "views" . $SEPARATOR . "footer_view.php";

            if(!Router::HasError()){ 
        ?>
            <script type="application/javascript" src="/static/js/libs/jquery-3.3.1.slim.min.js"></script>
            <script type="application/javascript" src="/static/js/bootstrap.min.js"></script>
        <?php 
            }
            if(isset($src_static_files)) {
                foreach($src_static_files as $static_element){
                    if(isset($static_element['type']) && isset($static_element['src']) && isset($static_element['place']) && $static_element['place'] == "after"){
                        switch($static_element['type']){
                            case "css":
                                ?>
                                <link rel="stylesheet" type="text/css" href="/<?=$static_element['src']?>" />
                                <?php
                            break;
                            case "js":
                                ?>
                                <script type="application/javascript" src="/<?=$static_element['src']?>"></script>
                                <?php
                            break;
                            default: break;
                        }
                    }
                }
            }
        ?>
    </body>
</html>