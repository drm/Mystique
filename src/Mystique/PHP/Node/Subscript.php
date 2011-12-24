<?php

namespace Mystique\PHP\Node;

class Subscript extends BinaryExpression {
    function __construct(Node $var, $subscript, \Mystique\PHP\Token\Operator $type = null) {
        BranchAbstract::__construct();
        $this->children[0] = $var;
        if($type) {
            $this->children[1] = $type;
        }
        if($subscript && count($subscript)) {
            $this->children[2] = $subscript;
        }
    }

    function getOperator() {
        return $this->children[1];
    }

    
    function getLeft() {
        return $this->children[0];
    }

    
    function setLeft($lValue) {
        $this->children[0] = $lValue;
    }

    function compile(\Mystique\Compiler\CompilerInterface $compiler) {
        if(!$this->children instanceof \Mystique\Compiler\Compilable) {
            throw new \UnexpectedValueException("Unexpected children of type " . gettype($this->children) . ' in ' . get_class($this));
        }
        $this->children[0]->compile($compiler);
        $compiler->write($this->getOperator()->type);
        if(isset($this->children[2])) {
            $this->children[2]->compile($compiler);
        }
        $compiler->write(\Mystique\PHP\Token\PairMatcher::parenOf($this->getOperator()->type));
    }
}