<?php

namespace Meander\PHP\Node;


class ImplementsDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Implements';
    }
}