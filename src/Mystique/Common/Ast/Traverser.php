<?php

namespace Mystique\Common\Ast;
use UnexpectedValueException;
use Mystique\Common\Ast\Node\Node;
use Mystique\Common\Ast\Node\Branch;


class Traverser {
    function __construct(Visitor $visitor) {
        $this->visitor = $visitor;
    }

    function traverse(Node $node) {
        $this->visitor->enterNode($node);
        if($node instanceof Branch) {
            foreach((array)$node->getNodeChildren() as $child) {
                if(!$child instanceof Node) {
                    throw new UnexpectedValueException(
                        sprintf(
                            '%s::getNodeChildren() should return children of type Node, %s%s found',
                            get_class($node),
                            gettype($child),
                            is_scalar($child) ? " ($child)" : ''
                        )
                    );
                }
                $this->traverse($child);
            }
        } 
        $this->visitor->exitNode($node);
    }
}
