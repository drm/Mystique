<?php

namespace MeanderTest\PHP\Builder;

use \Meander\PHP\Node\FunctionNode;
use \Meander\PHP\Builder\FunctionBuilder;
        
class FunctionBuilderTest extends \MeanderTest\TestCase {
    function setUp()
    {
        $this->node = new FunctionNode('some_function');
        $this->builder = new FunctionBuilder($this->node, '\Meander\PHP\Node\\');
        $this->compiler = new \Meander\Compiler\Compiler();
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