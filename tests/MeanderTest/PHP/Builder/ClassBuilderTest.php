<?php

namespace MeanderTest\Builder;
use \Meander\PHP\Builder\ClassBuilder;
use \Meander\PHP\Node\ClassDefinition;
use \Meander\PHP\Builder;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Meander\PHP\Builder\ClassBuilder
 */

class ClassBuilderTest extends PHPUnit_Framework_TestCase
{
    function setUp() {
        $this->builder = new ClassBuilder(new ClassDefinition('some_class'), '\Meander\PHP\Node\\');
    }

    function testMethodCreationYieldsMethodBuilder() {
        $this->assertInstanceOf('\Meander\PHP\Builder\MethodBuilder', $this->builder->method('b'));
    }

    function testPropertyCreationYieldsPropertyBuilder() {
        $this->assertInstanceOf('\Meander\PHP\Builder\PropertyBuilder', $this->builder->property('b'));
    }
}