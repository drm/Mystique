<?php

namespace Meander\PHP\Node;

class Condition implements Branch, \Meander\Compiler\Compilable {
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

    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->write('(');
        $compiler->compile($this->expr);
        $compiler->write(')');
    }
}