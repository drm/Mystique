<?php
namespace Meander\PHP\Node;
use \Meander\Compiler\CompilerInterface;

class Name extends \Meander\PHP\Node\LeafAbstract implements \Meander\Compiler\Compilable
{
    function __construct($name) {
        $this->name = $name;
    }

    function compile(CompilerInterface $compiler)
    {
        $compiler->write($this->name);
    }

    function __toString() {
        return $this->name;
    }

    function getNodeValue()
    {
        return $this->name;
    }
}