<?php

namespace MeanderTest\Node;
use \Meander\PHP\Node\FunctionNode;

class FunctionNodeTest extends \MeanderTest\TestCase {
    function testInitialStructureContainsDeclarationAndDefinition() {
        $node = new FunctionNode();
        $this->assertInstanceOf('\Meander\PHP\Node\FunctionDeclaration', $node->children[0]);
        $this->assertInstanceOf('\Meander\PHP\Node\FunctionDefinition', $node->children[1]);
    }


    function testCompilationWillCompileDeclarationAndDefinition() {
        $node = new FunctionNode();
        $node->children[0] = $this->getMock('\Meander\PHP\Node\FunctionDeclaration', array('compile'));
        $node->children[1] = $this->getMock('\Meander\PHP\Node\FunctionDefinition', array('compile'));
        
        $node->children[0]->expects($this->once())->method('compile');
        $node->children[1]->expects($this->once())->method('compile');

        $compiler = new \Meander\Compiler\Compiler();
        $node->compile($compiler);
    }
}