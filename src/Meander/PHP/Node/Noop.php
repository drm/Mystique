<?php
namespace Meander\PHP\Node;

class Noop extends LeafAbstract implements \Meander\Compiler\Compilable {
    function __construct($remark = '') {
//        parent::__construct();
        $this->remark = $remark;
    }

    function getNodeValue()
    {
        return $this->remark;
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
    }
}