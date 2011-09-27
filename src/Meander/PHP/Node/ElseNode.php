<?php

namespace Meander\PHP\Node;

class ElseNode extends BranchAbstract {
    function getNodeType()
    {
        return 'Else';
    }
}