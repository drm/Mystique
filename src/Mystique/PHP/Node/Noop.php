<?php
namespace Mystique\PHP\Node;

class Noop extends LeafAbstract implements \Mystique\Compiler\Compilable {
    function __construct($remark = '') {
//        parent::__construct();
        $this->remark = $remark;
    }

    function getNodeValue()
    {
        return $this->remark;
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
    }
}