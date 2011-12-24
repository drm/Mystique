<?php

namespace Meander\PHP\Node;

class CaseBody extends \Meander\PHP\Node\BranchAbstract {
    function getNodeType() {
        return 'Body';
    }
}