<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;
use Countable;

/**
 * 
 */

abstract class BranchAbstract extends NodeAbstract implements Branch, Countable {
    public $children;

    function __construct($list = null) {
        $this->children = $list ?: new NodeList();
        if(! $this->children instanceof NodeList) {
            throw new \InvalidArgumentException("Require node list as parameter in construction of " . get_class($this));
        }
    }


    function getNodeChildren() {
        return $this->children;
    }


    function compile(CompilerInterface $compiler) {
        $this->children->compile($compiler);
    }


    public function add(Node $n) {
        $this->children[]=$n;
    }


    function hasAttribute($name) {
        return !empty($this->attributes[$name]);
    }


    function getAttribute($name) {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }


    function setAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }


    function getNodeAttributes() {
        return $this->attributes;
    }


    function removeAttribute($name) {
        unset($this->attributes[$name]);
    }


    function setFlag($name, $set) {
        if($set) {
            $this->setAttribute($name, "true");
        } else {
            $this->removeAttribute($name);
        }
    }


    function count() {
        return count($this->children);
    }
}