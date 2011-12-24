<?php
namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\LeafAbstract;

class Noop extends LeafAbstract implements \Mystique\Common\Compiler\Compilable {
    function __construct($remark = '') {
//        parent::__construct();
        $this->remark = $remark;
    }

    function getNodeValue()
    {
        return $this->remark;
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
    }
}