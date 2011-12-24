<?php

namespace Mystique\PHP\Node;

class CaseBody extends \Mystique\PHP\Node\BranchAbstract {
    function getNodeType() {
        return 'Body';
    }
}