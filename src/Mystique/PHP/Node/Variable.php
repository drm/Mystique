<?php
namespace Mystique\PHP\Node;

use \Mystique\Compiler\CompilerInterface;

class Variable extends VariableAbstract implements \Mystique\Compiler\Compilable
{
    function __construct($name)
    {
        $this->name = $name;
    }

    function compile(CompilerInterface $compiler)
    {
        $compiler->write('$');
        $this->compileName($compiler, $this->name);
    }

    function getNodeValue()
    {
        return $this->name;
    }
}