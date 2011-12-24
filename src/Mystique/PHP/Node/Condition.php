<?php

namespace Mystique\PHP\Node;

class Condition implements Branch, \Mystique\Compiler\Compilable {
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

    function compile(\Mystique\Compiler\CompilerInterface $compiler) {
        $compiler->write('(');
        $compiler->compile($this->expr);
        $compiler->write(')');
    }
}