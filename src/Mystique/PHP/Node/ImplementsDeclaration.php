<?php

namespace Mystique\PHP\Node;


class ImplementsDeclaration extends BranchAbstract {
    function getNodeType() {
        return 'Implements';
    }
}