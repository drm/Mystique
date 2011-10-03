<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Node\Condition;
class DoWhileNode extends WhileNode {
    function getNodeType()
    {
        return 'DoWhile';
    }
}