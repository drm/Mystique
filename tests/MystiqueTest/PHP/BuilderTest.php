<?php

namespace MystiqueTest\PHP;
use PHPUnit_Framework_TestCase;
use \Mystique\PHP\Builder;


/**
 * @covers \Mystique\PHP\Builder
 */
class BuilderTest extends PHPUnit_Framework_TestCase {
    function testBuilderWillYieldClassBuilderOnClassCreation () {
        $builder = new Builder();
        $this->assertInstanceOf('\Mystique\PHP\Builder\ClassBuilder', $builder->cls('a')->peek());
    }

    
    function testBuilderWillYieldFunctionBuilderOnFunctionCreation() {
        $builder = new Builder();
        $this->assertInstanceOf('\Mystique\PHP\Builder\FunctionBuilder', $builder->fn('b')->peek());
    }
}