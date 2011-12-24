<?php
namespace Mystique\PHP\Node;

use \Mystique\Common\Compiler\CompilerInterface;

class Variable extends VariableAbstract implements \Mystique\Common\Compiler\Compilable
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