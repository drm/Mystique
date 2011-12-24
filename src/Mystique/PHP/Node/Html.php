<?php

namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\LeafAbstract;

class Html extends LeafAbstract implements \Mystique\Common\Compiler\Compilable {
    function __construct($data) {
        $this->html = $data;
    }

    function getNodeValue()
    {
        return $this->html;
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write($this->html);
    }
}