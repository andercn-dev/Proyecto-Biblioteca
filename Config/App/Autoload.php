<?php
date_default_timezone_set('America/Lima');

spl_autoload_register(function($class){
    if (file_exists("Config/App/".$class.".php")) {
        require_once "Config/App/" . $class . ".php";
    }
})
?>