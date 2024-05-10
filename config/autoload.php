<?php
namespace config;
class Autoload {
        
    public static function Start() {
        spl_autoload_register(function($classPath)
        {
            $class = dirname(__DIR__) ."/" . str_replace("\\", "/", $classPath)  . ".php";
            if (file_exists($class)){
                include_once($class);
            }           
        });
    }
}

?>