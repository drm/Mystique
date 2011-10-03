<?php

//TODO this can be made generic
namespace Meander\PHP\Node;
use UnexpectedValueException;

class Traverser {
    function __construct(Visitor $visitor) {
        $this->visitor = $visitor;
    }

    function traverse($node) {
        $this->visitor->enterNode($node);
        if($node instanceof Branch) {
            foreach((array)$node->getNodeChildren() as $child) {
                if(!$child instanceof Node) {
                    throw new UnexpectedValueException("getNodeChildren() implementation of " . get_class($node) . ' should return children of type Node, ' . gettype($child) . ' found');
                }
                $this->traverse($child);
            }
        } 
        $this->visitor->exitNode($node);
    }
}
