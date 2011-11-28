<?php
namespace Meander\PHP\Node;

class Placeholder extends \Meander\PHP\Node\BranchAbstract {
    function __construct(Node $node) {
        parent::__construct();
        $this->children->append($node);
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('{');
        parent::compile($compiler);
        $compiler->write('}');
    }
}