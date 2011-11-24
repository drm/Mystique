<?php

namespace Meander\PHP\Node;

use \Meander\Compiler\Compilable;
use \Meander\Compiler\CompilerInterface;
use IteratorIterator;
use ArrayIterator;

class NodeList extends ArrayIterator implements Compilable {
    function __construct() {
        parent::__construct(array());
    }


    function append($node) {
        parent::append($node);
    }


    function compile(CompilerInterface $compiler)
    {
        foreach($this as $node) {
            $compiler->compile($node);
        }
    }


    function peek() {
        return $this->current();
    }
}