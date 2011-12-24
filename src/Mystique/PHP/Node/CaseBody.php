<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\BranchAbstract;

class CaseBody extends BranchAbstract {
    function getNodeType() {
        return 'Body';
    }
}