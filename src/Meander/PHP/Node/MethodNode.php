<?php

namespace Meander\PHP\Node;

class MethodNode extends FunctionNode {
    function setDeclaration()
    {
        $this->children[0] = new MethodDeclaration();
    }

    function getNodeType()
    {
        return 'Method';
    }


    function setAbstract($abstract = true) {
        $this->children[0]->setAbstract($abstract);
        if($abstract) {
            unset($this->children[1]);
        } elseif(!isset($this->children[1])) {
            $this->setDefinition();
        }
        return $this;
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        parent::compile($compiler);
        if(!isset($this->children[1])) {
            $compiler->write(';');
        }
    }


}