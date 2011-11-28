<?php
namespace Meander\PHP\Node;

class InterfaceDeclaration extends BranchAbstract implements \Meander\Compiler\Compilable {
    static $type = 'interface';

    function getNodeType() {
        return 'Declaration';
    }


    function setName($name) {
        $this->children[0] = $name;
    }

    
    function getName() {
        return $this->children[0];
    }


    function getExtends() {
        if(isset($this->children[1])) {
            return $this->children[1];
        }
        return null;
    }


    function haveExtends() {
        if(!isset($this->children[1])) {
            $this->children[1]= new ExtendsDeclaration();
        }
        return $this->children[1];
    }


    function addExtends($name) {
        return $this->haveExtends()->add($name);
    }
    

    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler
                ->write('interface')
                ->compile($this->getName())
        ;

        if(!empty($this->children[1])) {
            /** @var $extends \Meander\PHP\Node\ExtendsDeclaration */
            $compiler->write('extends')->compile($this->getExtends());
        }
    }
}