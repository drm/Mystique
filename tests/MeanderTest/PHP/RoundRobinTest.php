<?php

class RoundRobinTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->parser = new \Meander\PHP\Parser\FileParser();
    }

    /**
     * @dataProvider files
     * @param $file
     * @return void
     */
    function testThatCompilingParsedDoesNotAffectSyntax($file) {
        $this->parser->parse(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenize(file_get_contents($file))));
    }


    function files() {
//        return array(
//            array('/home/gerard/work/meander/tests/MeanderTest/PHP/../../../src/Meander/PHP/Formatter/Simple.php')
//        );

        return array_map(
            function(SplFileInfo $f) { return array($f->getPathName()); },
            iterator_to_array(
                new RegexIterator(
                    new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../../../')),
                    '/\.php$/'
                )
            )
        );
    }
}