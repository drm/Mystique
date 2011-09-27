<?php

namespace Meander\PHP\Node;

class Condition implements Branch {
    function __construct($expr) {
        $this->expr = $expr;
    }


    function getNodeChildren()
    {
        return array($this->expr);
    }

    function getNodeType()
    {
        return 'condition';
    }

}