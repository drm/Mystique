<?php
namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;

class Variable extends VariableAbstract implements \Meander\Compiler\Compilable
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