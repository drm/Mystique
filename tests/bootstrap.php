<?php

require_once __DIR__ . '/../src/autoload.php';

spl_autoload_register(function($class) {
    if(strpos($class, 'MystiqueTest\\') === 0) {
        $fn = __DIR__ . '/../tests/' . str_replace('\\', '/', $class) . '.php';
        if(is_file($fn)) {
            require_once($fn);
            return true;
        }
    }
    return false;
});

//require_once __DIR__.'/MystiqueTest/PHP/Assert.php';