<?php
/**
 * 
 */

namespace MeanderTest\PHP\MethodDefinitionTest;
use PHPUnit_Framework_TestCase;

use \Meander\PHP\Builder\MethodBuilder;
use \Meander\PHP\Node\MethodDeclaration;

class MethodBuilderTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->builder = new MethodBuilder(new MethodDeclaration('some_method'), '\Meander\PHP\Node\\');
    }


    function testParameterBuilder() {
        $this->assertInstanceOf('\Meander\PHP\Builder\ParameterBuilder', $this->builder->param('a'));
    }
}