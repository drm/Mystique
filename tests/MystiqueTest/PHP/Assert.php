<?php

namespace MystiqueTest\PHP;
use PHPUnit_Framework_Assert;
use \Mystique\PHP\Formatter\Simple;

class Assert extends PHPUnit_Framework_Assert {
    static function assertSyntaxEquals($expected, $actual, $message = 'Failed asserting that two pieces of code are equal') {
        $normalizer = new Simple();
        if(!preg_match('/^<\?php/', $expected)) {
            $expected = "<?php $expected";
            $actual = "<?php $actual";
        }
        self::assertEquals($normalizer->format($expected), $normalizer->format($actual), $message);
    }


    static function assertSyntaxValid($code, $message = 'Failed asserting that the syntax of the code is valid') {
        self::assertTrue(\Mystique\PHP\Lint::lintPhp($code), \Mystique\PHP\Lint::$lastMessage, $message);
    }
}
