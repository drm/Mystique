<?php

namespace MeanderTest\PHP;
use PHPUnit_Framework_TestCase;
use \Meander\PHP\Builder;


/**
 * @covers \Meander\PHP\Builder
 */
class BuilderTest extends PHPUnit_Framework_TestCase {
    function testBuilderWillYieldClassBuilderOnClassCreation () {
        $builder = new Builder();
        $this->assertInstanceOf('\Meander\PHP\Builder\ClassBuilder', $builder->cls('a')->peek());
    }

    
    function testBuilderWillYieldFunctionBuilderOnFunctionCreation() {
        $builder = new Builder();
        $this->assertInstanceOf('\Meander\PHP\Builder\FunctionBuilder', $builder->fn('b')->peek());
    }
}