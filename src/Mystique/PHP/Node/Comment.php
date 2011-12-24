<?php

namespace Mystique\PHP\Node;

class Comment extends LeafAbstract {
    function __construct($comment) {
        $this->comment = $comment;
    }

    function getNodeValue()
    {
        return $this->comment;
    }
}
