<?php
namespace Mystique\PHP\Node;
use \Mystique\Compiler\CompilerInterface;

class UseList extends \Mystique\PHP\Node\ExprList {
    function compile(CompilerInterface $compiler)
    {
        $compiler->write('(');
        parent::compile($compiler);
        $compiler->write(')');
    }

    function getNodeType()
    {
        return 'Use';
    }
}