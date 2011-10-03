<?php

namespace Meander\PHP\Node;

use \Meander\PHP\Node\Condition;
class ForNode extends \Meander\PHP\Node\BranchAbstract {
    function __construct($expr, Node $statement) {
        parent::__construct();
        foreach($expr as $e) {
            $this->children->append($e ?: new Noop());
        }
        $this->children->append($statement);
    }

    function getNodeType()
    {
        return 'For';
    }
}
