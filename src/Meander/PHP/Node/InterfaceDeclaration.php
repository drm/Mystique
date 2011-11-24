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


    function setExtends($name) {
        $this->children[1]= new ExtendsDeclaration($name);
        return $this;
    }

    function getExtends() {
        return $this->children[1];
    }
    

    function compile(\Meander\Compiler\CompilerInterface $compiler) {
        $compiler
                ->write('interface')
                ->write($this->getName()->getNodeValue())
        ;

        if(!empty($this->children[1])) {
            /** @var $extends \Meander\PHP\Node\ExtendsDeclaration */
            $compiler->write('extends')->write((string)$this->getExtends());
        }
    }
}