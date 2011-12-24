<?php
namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\NodeList;

abstract class DefDeclNodeAbstract extends BranchAbstract implements \Mystique\Common\Compiler\Compilable, DocumentedNode {
    function __construct() {
        parent::__construct();
        $this->setDeclaration();
        $this->setDefinition(new NodeList());
    }

    function __call($method, $args) {
        $ret = null;
        
        if(!isset($this->children[0])) {
            throw new \BadMethodCallException("Possible error in constructor; declaration node was not defined");
        }
        if(method_exists($this->children[0], $method)) {
            $ret = call_user_func_array(array($this->children[0], $method), $args);
            if($ret === $this->children[0]) {
                // maintain fluent interface
                $ret = $this;
            }
        } elseif(isset($this->children[1]) && is_callable(array($this->children[1], $method))) {
            $ret = call_user_func_array(array($this->children[1], $method), $args);
            if($ret === $this->children[1]) {
                // maintain fluent interface
                $ret = $this;
            }
        } else {
            throw new \BadMethodCallException("Undefined method $method in " . get_class($this));
        }
        return $ret;
    }


    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        $compiler->compile($this->children[0]);

        if(isset($this->children[1])) {
            $compiler->compile($this->children[1]);
        }
    }

    abstract function setDeclaration();
    abstract function setDefinition(NodeList $definition);

    function getDocBlock() {
        if($slice = $this->getTokenSlice()) {
            $i = $slice->left;
            do {
                $i --;
            } while($i >= 0 && $slice->stream->tokenAt($i)->match(T_WHITESPACE));
            if($i >= 0 && $slice->stream->tokenAt($i)->match(T_DOC_COMMENT)) {
                return $slice->stream->tokenAt($i)->value;
            }
        }
        return null;
    }
}