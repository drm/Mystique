<?php
namespace Meander\PHP\Node;
use \Meander\Compiler\CompilerInterface;

class UseList extends \Meander\PHP\Node\ExprList {
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