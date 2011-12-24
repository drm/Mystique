<?php
namespace Mystique\PHP\Node;
use \Mystique\Compiler\CompilerInterface;

class Name extends \Mystique\PHP\Node\LeafAbstract implements \Mystique\Compiler\Compilable
{
    function __construct($name) {
        $this->name = (string)$name;
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