<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\Expr\BinaryExpression;
use Mystique\Common\Ast\Node\Node;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\PHP\Token\PairMatcher;
use Mystique\Common\Compiler\CompilerInterface;
use Mystique\Common\Compiler\Compilable;

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

    function compile(CompilerInterface $compiler) {
        if(!$this->children instanceof Compilable) {
            throw new \UnexpectedValueException("Unexpected children of type " . gettype($this->children) . ' in ' . get_class($this));
        }
        $this->children[0]->compile($compiler);
        $compiler->write($this->getOperator()->type);
        if(isset($this->children[2])) {
            $this->children[2]->compile($compiler);
        }
        $compiler->write(PairMatcher::parenOf($this->getOperator()->type));
    }
}