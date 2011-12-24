<?php
namespace Mystique\Common\Ast\Node\Expr;

use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Compiler\CompilerInterface;

class ParenthesizedExpression extends BranchAbstract {
    function __construct($expression = null)
    {
        parent::__construct();
        if($expression) {
            $this->setExpression($expression);
        }
    }


    function setExpression($expression) {
        $this->children[0] = $expression;
    }


    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        $compiler->write('(');
        parent::compile($compiler);
        $compiler->write(')');
    }

    function getNodeType()
    {
        return 'Paren';
    }
}