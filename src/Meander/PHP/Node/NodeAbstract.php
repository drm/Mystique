<?php

namespace Meander\PHP\Node;

abstract class NodeAbstract implements Node {
    protected $attributes = array();

    function getNodeType() {
        $className = get_class($this);
        if(preg_match('/([^\\\\]+)$/', $className, $m)) {
            return $m[1];
        }
        return $className;
    }



    function getNodeAttributes() {
        return $this->attributes;
    }
}