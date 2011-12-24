<?php
namespace Mystique\PHP\Node;
        
class TypeHint extends BranchAbstract implements \Mystique\Compiler\Compilable {
    function __construct($type) {
        parent::__construct();
        $this->setType($type);
    }

    function setType(Node $type) {
        $this->children[0] = $type;
    }


    function compile(\Mystique\Compiler\CompilerInterface $compiler) {
        $compiler->compile($this->children[0]);
    }
}