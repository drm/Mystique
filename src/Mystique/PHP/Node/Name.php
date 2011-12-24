<?php
namespace Mystique\PHP\Node;
use \Mystique\Common\Compiler\CompilerInterface;
use Mystique\Common\Ast\Node\LeafAbstract;

class Name extends LeafAbstract implements \Mystique\Common\Compiler\Compilable
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