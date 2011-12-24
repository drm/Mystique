<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\Branch;
use \Mystique\Common\Compiler\Compilable;

class Condition implements Branch, Compilable {
    function __construct($expr) {
        $this->expr = $expr;
    }


    function getNodeChildren()
    {
        return array($this->expr);
    }

    function getNodeType()
    {
        return 'condition';
    }

    function getNodeAttributes()
    {
        return array();
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        $compiler->write('(');
        $compiler->compile($this->expr);
        $compiler->write(')');
    }
}