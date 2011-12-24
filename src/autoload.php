<?php

spl_autoload_register(function($class){
    if($class{0} == '\\') {
        $class = substr($class, 1);
    }
    if(strpos($class, 'Mystique\\') == 0) {
        $fn = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
        if(is_file($fn)) {
            require_once($fn);
            return true;
        }
    }
    return false;
});
