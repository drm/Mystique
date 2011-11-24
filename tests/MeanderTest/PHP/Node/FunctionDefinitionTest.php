<?php

/**
 * 
 */
use MeanderTest\PHP\CompilerTestCase;
use \MeanderTest\PHP\Assert;

class FunctionDefinitionTest {
    function testNameless() {
        $def = new \Meander\PHP\Node\FunctionDeclaration();
        Assert::assertSyntaxEquals(
            'function () {}',
            $this->compiler->compile($def)->result
        );
    }

    function testNamed() {
        $def = new \Meander\PHP\Node\FunctionDeclaration('a');
        Assert::assertSyntaxEquals(
            'function a () {}',
            $this->compiler->compile($def)->result
        );
    }
}