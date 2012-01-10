<?php

namespace Mystique\Common\Inspector\Matcher;

use Mystique\Common\Ast\Node\Node;

interface MatcherInterface {
    function match(Node $node);
}