<?php
/**
 * 
 */

namespace MystiqueTest\PHP\MethodDefinitionTest;
use PHPUnit_Framework_TestCase;

use \Mystique\PHP\Builder\MethodBuilder;
use \Mystique\PHP\Node\MethodDeclaration;

class MethodBuilderTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->builder = new MethodBuilder(new MethodDeclaration('some_method'), '\Mystique\PHP\Node\\');
    }


    function testParameterBuilder() {
        $this->assertInstanceOf('\Mystique\PHP\Builder\ParameterBuilder', $this->builder->param('a'));
    }
}