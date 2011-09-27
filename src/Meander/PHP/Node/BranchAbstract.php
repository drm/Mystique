<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\CompilerInterface;

/**
 * 
 */

abstract class BranchAbstract extends NodeAbstract implements Branch {
    public $children;

    function __construct($list = null) {
        $this->children = $list ?: new NodeList();
    }


    function getNodeChildren() {
        return $this->children;
    }


    function compile(CompilerInterface $compiler) {
        $this->children->compile($compiler);
    }
}