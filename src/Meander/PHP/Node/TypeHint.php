<?php
namespace Meander\PHP\Node;
        
class TypeHint extends BranchAbstract implements \Meander\Compiler\Compilable {
    function __construct($type) {
        parent::__construct();
        $this->setType($type);
    }

    function setType(Node $type) {
        $this->children[0] = $type;
    }


    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler->compile($this->children[0]);
    }
}