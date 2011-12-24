<?php
namespace Mystique\PHP\Node;

class Placeholder extends \Mystique\PHP\Node\BranchAbstract {
    function __construct(Node $node) {
        parent::__construct();
        $this->children->append($node);
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('{');
        parent::compile($compiler);
        $compiler->write('}');
    }
}