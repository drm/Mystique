<?php

namespace Mystique\PHP\Node;

class Html extends LeafAbstract implements \Mystique\Compiler\Compilable {
    function __construct($data) {
        $this->html = $data;
    }

    function getNodeValue()
    {
        return $this->html;
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->html);
    }
}