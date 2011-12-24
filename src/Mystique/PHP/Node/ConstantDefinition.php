<?php

namespace Mystique\PHP\Node;

class ConstantDefinition extends BranchAbstract {
    function setName($name) {
        $this->children[0] = $name;
    }


    function setValue($value) {
        $this->children[1] = $value;
    }
    

    function compile(\Mystique\Compiler\CompilerInterface $compiler)
    {
        $compiler->write('const')->compile($this->children[0])->write('=')->compile($this->children[1])->write(';');
    }
}