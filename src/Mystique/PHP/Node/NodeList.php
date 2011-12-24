<?php

namespace Mystique\PHP\Node;

use \Mystique\Compiler\Compilable;
use \Mystique\Compiler\CompilerInterface;
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