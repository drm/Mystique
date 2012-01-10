<?php

namespace Mystique\Common\Inspector\Matcher;

use Mystique\Common\Ast\Node\Node;

class NodeType implements MatcherInterface {
    function __construct($type) {
        $this->type = $type;
    }


    function match(Node $node) {
        return $node instanceof $this->type;
    }
}