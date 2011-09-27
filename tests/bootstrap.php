<?php

require_once __DIR__ . '/../src/autoload.php';

spl_autoload_register(function($class) {
    if(substr($class, 0, 12) == 'MeanderTest\\') {
        $fn = __DIR__ . '/../tests/' . str_replace('\\', '/', $class) . '.php';
        if(is_file($fn)) {
            require_once($fn);
            return true;
        }
    }
    return false;
});

//require_once __DIR__.'/MeanderTest/PHP/Assert.php';