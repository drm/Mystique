<?php


namespace Meander\PHP\Node;

abstract class DefDeclNodeAbstract extends BranchAbstract {
    function __construct() {
        parent::__construct();
        $this->setDeclaration();
        $this->children[0] = new MethodDeclaration();
    }

    abstract function setDeclaration();
    abstract function setDefinition(NodeList $definition);

    function __call($method, $args) {
        if(method_exists($this->children[0], $method)) {
            return call_user_func_array(array($this->children[0], $method), $args);
        }
        if(isset($this->children[1])) {
            return call_user_func_array(array($this->children[1], $method), $args);
        }
    }
}