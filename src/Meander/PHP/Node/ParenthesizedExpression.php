<?php
namespace Meander\PHP\Node;

class ParenthesizedExpression extends \Meander\PHP\Node\BranchAbstract {
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


    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->write('(');
        parent::compile($compiler);
        $compiler->write(')');
    }

    function getNodeType()
    {
        return 'Paren';
    }
}