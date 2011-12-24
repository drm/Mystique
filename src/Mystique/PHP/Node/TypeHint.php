<?php
namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\Node;

class TypeHint extends BranchAbstract implements \Mystique\Common\Compiler\Compilable {
    function __construct($type) {
        parent::__construct();
        $this->setType($type);
    }

    function setType(Node $type) {
        $this->children[0] = $type;
    }


    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        $compiler->compile($this->children[0]);
    }
}