<?php

namespace MeanderTest\Builder;
use \Meander\PHP\Builder\ClassBuilder;
use \Meander\PHP\Node\ClassNode;
use \Meander\PHP\Builder;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Meander\PHP\Builder\ClassBuilder
 */

class ClassBuilderTest extends PHPUnit_Framework_TestCase
{
    function setUp()
    {
        $this->node = new ClassNode('some_class');
        $this->builder = new ClassBuilder($this->node, '\Meander\PHP\Node\\');
    }


    function testSetExtends()
    {
        $this->builder->setExtends('x');
        $this->assertEquals('x', (string)$this->node->getExtends());
    }

    function testExt()
    {
        $this->builder->ext('x');
        $this->assertEquals('x', (string)$this->node->getExtends());
    }

    function testMethodCreationYieldsMethodBuilder()
    {
        $this->assertInstanceOf('\Meander\PHP\Builder\MethodBuilder', $this->builder->method('b'));
    }

    function testPropertyCreationYieldsPropertyBuilder()
    {
        $this->assertInstanceOf('\Meander\PHP\Builder\PropertyBuilder', $this->builder->property('b'));
    }
}