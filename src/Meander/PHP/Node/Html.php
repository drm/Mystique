<?php

namespace Meander\PHP\Node;

class Html extends LeafAbstract implements \Meander\Compiler\Compilable {
    function __construct($data) {
        $this->html = $data;
    }

    function getNodeValue()
    {
        return $this->html;
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->html);
    }
}