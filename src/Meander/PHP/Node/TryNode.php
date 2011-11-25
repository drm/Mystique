<?php
namespace Meander\PHP\Node;

class TryNode extends BranchAbstract {
    function getNodeType()
    {
        return 'Try';
    }

}