<?php

namespace Mystique\Concept\Node;
use Mystique\Common\Ast\Node\LeafAbstract;

class Comment extends LeafAbstract {
    function __construct($comment) {
        $this->comment = $comment;
    }

    function getNodeValue()
    {
        return $this->comment;
    }
}
