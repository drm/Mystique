<?php

namespace MeanderTest\PHP\Formatter;

use PHPUnit_Framework_TestCase;
use DirectoryIterator;
use \Meander\PHP\Formatter\Simple;

class SimpleTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider codeSamples
     */
    function testFormattingAfterDeflating($code) {
        $deflate = new \Meander\PHP\Formatter\Deflate();
        $simple = new Simple();
        $this->assertEquals($code, $simple->format($deflate->format($code)));
    }

    /**
     * @dataProvider codeSamples
     */
    function testFormattingAsIs($code) {
        $simple = new Simple();
        $this->assertEquals($code, $simple->format($code));
    }


    function codeSamples() {
        if(!defined('MEANDER_TEST_ASSETS')) {
            $this->markTestSkipped('Asset dir not available');
        }
        $ret = array();
        foreach(new DirectoryIterator(MEANDER_TEST_ASSETS. '/Formatter/Simple/') as $file) {
            if(!$file->isDot()) {
                $ret[]= array(file_get_contents($file->getPathName()));
            }
        }
        return $ret;
    }
}