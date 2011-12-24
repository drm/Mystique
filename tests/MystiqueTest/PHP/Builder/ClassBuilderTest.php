<?php

namespace MystiqueTest\Builder;
use \Mystique\PHP\Builder\ClassBuilder;
use \Mystique\PHP\Node\ClassNode;
use \Mystique\PHP\Builder;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Mystique\PHP\Builder\ClassBuilder
 */

class ClassBuilderTest extends PHPUnit_Framework_TestCase
{
    function setUp()
    {
        $this->node = new ClassNode('some_class');
        $this->builder = new ClassBuilder($this->node, '\Mystique\PHP\Node\\');
    }


    function testMethodCreationYieldsMethodBuilder()
    {
        $this->assertInstanceOf('\Mystique\PHP\Builder\MethodBuilder', $this->builder->method('b'));
    }

    function testPropertyCreationYieldsPropertyBuilder()
    {
        $this->assertInstanceOf('\Mystique\PHP\Builder\PropertyBuilder', $this->builder->property('b'));
    }
}