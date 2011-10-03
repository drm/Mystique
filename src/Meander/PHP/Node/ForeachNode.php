<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Node\Condition;
class ForeachNode extends ForNode {
    function getNodeType()
    {
        return 'Foreach';
    }
}
