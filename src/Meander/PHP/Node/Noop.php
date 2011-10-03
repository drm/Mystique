<?php
namespace Meander\PHP\Node;

class Noop extends LeafAbstract {
    function __construct($remark = '') {
//        parent::__construct();
        $this->remark = $remark;
    }

    function getNodeValue()
    {
        return $this->remark;
    }
}