<?php

namespace Meander\PHP\Node;

abstract class NodeAbstract implements Node {
    protected $parens;
    protected $attributes = array();

    function getNodeType() {
        $className = get_class($this);
        if(preg_match('/([^\\\\]+)$/', $className, $m)) {
            return $m[1];
        }
        return $className;
    }


    function setParens($parens = true) {
        $this->parens = (bool)$parens;
    }


    function hasParens() {
        return $this->parens;
    }


    function getNodeAttributes() {
        return $this->attributes;
    }
}