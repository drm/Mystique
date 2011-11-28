<?php

namespace MeanderTest\PHP;
use PHPUnit_Framework_Assert;
use \Meander\PHP\Formatter\Simple;

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
        self::assertTrue(\Meander\PHP\Lint::lintPhp($code), \Meander\PHP\Lint::$lastMessage, $message);
    }
}
