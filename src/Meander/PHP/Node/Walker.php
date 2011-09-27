<?php

//TODO this can be made generic
namespace Meander\PHP\Node;
use UnexpectedValueException;

class Walker {
    function __construct(Visitor $visitor) {
        $this->visitor = $visitor;
    }

    function walk($node) {
        $this->visitor->enterNode($node);
        if($node instanceof Branch) {
            foreach($node->getNodeChildren() as $child) {
                if(!$child instanceof Node) {
                    throw new UnexpectedValueException("getNodeChildren() implementation of " . get_class($node) . ' should return children');
                }
                $this->walk($child);
            }
        } 
        $this->visitor->exitNode($node);
    }
}
