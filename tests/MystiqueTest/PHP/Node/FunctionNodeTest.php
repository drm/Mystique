<?php

namespace MystiqueTest\Node;
use \Mystique\PHP\Node\FunctionNode;

class FunctionNodeTest extends \MystiqueTest\TestCase {
    function testInitialStructureContainsDeclarationAndDefinition() {
        $node = new FunctionNode();
        $this->assertInstanceOf('\Mystique\PHP\Node\FunctionDeclaration', $node->children[0]);
        $this->assertInstanceOf('\Mystique\PHP\Node\FunctionDefinition', $node->children[1]);
    }


    function testCompilationWillCompileDeclarationAndDefinition() {
        $node = new FunctionNode();
        $node->children[0] = $this->getMock('\Mystique\PHP\Node\FunctionDeclaration', array('compile'));
        $node->children[1] = $this->getMock('\Mystique\PHP\Node\FunctionDefinition', array('compile'));
        
        $node->children[0]->expects($this->once())->method('compile');
        $node->children[1]->expects($this->once())->method('compile');

        $compiler = new \Mystique\Compiler\Compiler();
        $node->compile($compiler);
    }
}