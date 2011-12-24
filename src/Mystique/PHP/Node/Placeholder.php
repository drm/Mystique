<?php
namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\Node;

class Placeholder extends BranchAbstract {
    function __construct(Node $node) {
        parent::__construct();
        $this->children->append($node);
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('{');
        parent::compile($compiler);
        $compiler->write('}');
    }
}