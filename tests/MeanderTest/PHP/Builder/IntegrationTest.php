<?php

use \Meander\PHP\Builder;

class IntegrationTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider integrationTests
     */
    function testIntegration($builderCode, $expect, $fn) {
        if($fn !== 'cls.method.raw.test') {
            return;
        }
        $builder = new Builder();
        \MeanderTest\PHP\Assert::assertSyntaxValid($builderCode);
        eval($builderCode);
        $compiler = new \Meander\Compiler\Compiler();

        \MeanderTest\PHP\Assert::assertSyntaxEquals(trim($expect), $compiler->compile($builder->done())->result);
        \MeanderTest\PHP\Assert::assertSyntaxValid($compiler->compile($builder->done())->result);
    }

    function integrationTests() {
        $ret = array();
        foreach(new DirectoryIterator(MEANDER_TEST_ASSETS . '/Builder/Integration') as $file) {
            if(!$file->isDot()) {
                $ret[]= array_merge(
                    array_map('trim', explode("\n--\n", file_get_contents($file->getPathName()))),
                    array($file->getBaseName())
                );
            }
        }
        return $ret;
    }
}