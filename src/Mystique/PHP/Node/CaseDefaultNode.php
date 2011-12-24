<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Compiler\CompilerInterface;
use Mystique\Common\Ast\Node\BranchAbstract;

class CaseDefaultNode extends BranchAbstract {
    function __construct($body) {
        parent::__construct();
        $this->children[0] = $body;
    }

    function getNodeType() {
        return 'Default';
    }

    function compile(CompilerInterface $compiler)
    {
        $compiler->write('default')->write(':')->compile($this->children[0]);
    }
}