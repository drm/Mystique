<?php
namespace Mystique\PHP\Node;

class InterfaceDeclaration extends BranchAbstract implements \Mystique\Compiler\Compilable {
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
    

    function compile(\Mystique\Compiler\CompilerInterface $compiler) {
        $compiler
                ->write('interface')
                ->compile($this->getName())
        ;

        if(!empty($this->children[1])) {
            /** @var $extends \Mystique\PHP\Node\ExtendsDeclaration */
            if($extends = $this->getExtends()) {
                $compiler->write('extends');
                $first = true;
                foreach($extends->children as $impl) {
                    !$first and $compiler->write(',') or $first = false;
                    $compiler->compile($impl);
                }
            }
        }
    }
}