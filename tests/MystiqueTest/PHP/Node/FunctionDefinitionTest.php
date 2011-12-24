<?php

/**
 * 
 */
use MystiqueTest\PHP\CompilerTestCase;
use \MystiqueTest\PHP\Assert;

class FunctionDefinitionTest {
    function testNameless() {
        $def = new \Mystique\PHP\Node\FunctionDeclaration();
        Assert::assertSyntaxEquals(
            'function () {}',
            $this->compiler->compile($def)->result
        );
    }

    function testNamed() {
        $def = new \Mystique\PHP\Node\FunctionDeclaration('a');
        Assert::assertSyntaxEquals(
            'function a () {}',
            $this->compiler->compile($def)->result
        );
    }
}