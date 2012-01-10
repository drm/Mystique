<?php

namespace Mystique\Common\Inspector\Matcher;

use Mystique\Common\Ast\Node\Node;

class Callback implements MatcherInterface {
    function __construct($callback) {
        $this->callback = $callback;
    }


    function match(Node $node) {
        return call_user_func($this->callback, $node);
    }
}