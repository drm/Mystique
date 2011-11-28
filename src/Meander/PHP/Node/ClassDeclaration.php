<?php
namespace Meander\PHP\Node;

class ClassDeclaration extends InterfaceDeclaration {
    function isFinal() {
        return (bool)$this->getAttribute('final');
    }


    function isAbstract() {
        return $this->hasAttribute('abstract');
    }


    function setFinal($final = true) {
        $this->setFlag('final', $final);
        return $this;
    }

    function setExtends($name) {
        $this->children[1] = new ExtendsDeclaration();
        return $this->addExtends($name);
    }

    function setAbstract($abstract= true) {
        $this->setFlag('abstract', $abstract);
        return $this;
    }


    function getImplements() {
        if(isset($this->children[2])) {
            return $this->children[2];
        }
        return null;
    }


    function haveImplements() {
        if(!isset($this->children[2])) {
            $this->children[2]= new ImplementsDeclaration();
        }
        return $this->children[2];
    }
    

    function addImplements($name) {
        return $this->haveImplements()->add($name);
    }

    function compile(\Meander\Compiler\CompilerInterface $compiler)
    {
        $this->isFinal() && $compiler->write('final');
        $this->isAbstract() && $compiler->write('abstract');
        $compiler
                ->write('class')
                ->compile($this->getName())
        ;
        if(!empty($this->children[1])) {
             /** @var $extends \Meander\PHP\Node\ExtendsDeclaration */
             $compiler->write('extends')->compile($this->getExtends());
         }
         
        if($implements = $this->getImplements()) {
            $compiler->write('implements');
            $first = true;
            foreach($implements->children as $impl) {
                !$first and $compiler->write(',') or $first = false;
                $compiler->compile($impl);
            }
        }
    }
}