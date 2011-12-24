<?php

namespace Mystique\PHP;

use RuntimeException;

class Lint {
    public static $PHP_BIN = null;
    public static $lastMessage = '';


    public static function php() {
        if(is_null(self::$PHP_BIN)) {
            self::$PHP_BIN = trim(shell_exec('which php'));
        }
        return self::$PHP_BIN;
    }

    
    static function lint($php) {
        $pipes = array();
        $pd = proc_open(
            self::php() . ' -l',
            array(
                 0 => array('pipe', 'r'),
                 1 => array('pipe', 'w'),
                 2 => array('file', '/dev/null', 'w')
            ),
            $pipes
        );
        fwrite($pipes[0], $php);
        fclose($pipes[0]);
        // TODO response is not yet used, maybe later for debugging purposes?
        self::$lastMessage = fread($pipes[1], 4096);
        $ret = proc_close($pd);
        return $ret === 0;
    }

    


    static function lintPhp($php) {
        return self::lint('<?php ' . $php);
    }
}