<?php

namespace MystiqueTest\PHP\Builder;

use \Mystique\PHP\Node\FunctionNode;
use \Mystique\PHP\Builder\FunctionBuilder;
        
class FunctionBuilderTest extends \MystiqueTest\TestCase {
    function setUp()
    {
        $this->node = new FunctionNode('some_function');
        $this->builder = new FunctionBuilder($this->node, '\Mystique\PHP\Node\\');
        $this->compiler = new \Mystique\Common\Compiler\Compiler();
    }

    function testEmptyBuildWillYieldEmptyFunction() {
        $this->assertSyntaxEquals('function some_function(){}', $this->compiler->compile($this->node)->result);
    }


    function testSettingRawBodyWillSetFunctionBody() {
        $this->builder->raw('echo "foo";');
        $this->assertSyntaxEquals('function some_function(){ echo "foo"; }', $this->compiler->compile($this->node)->result);
    }


    function testSettingRawBodyAgainWillOverwriteFunctionBody() {
        $this->builder->raw('echo "foo";');
        $this->builder->raw('');
        $this->assertSyntaxEquals('function some_function(){}', $this->compiler->compile($this->node)->result);
    }
}