<?php

namespace Mystique\PHP;

use BadMethodCallException,
    ReflectionClass,
    InvalidArgumentException,
    \Mystique\PHP\Node\RootNode;

class Builder {
    private $stack = array();


    function __construct($namespace = '\Mystique\PHP\Node\\', $builderNamespace = '\Mystique\PHP\Builder\\') {
        $this->namespace = $namespace;
        $this->builderNamespace = $builderNamespace;
        $this->reset();
    }


    private function _factory($name, $args) {
        if(class_exists($className = $this->namespace . $name, true)) {
            $refl = new ReflectionClass($className);
            return $refl->newInstanceArgs($args);
        }
        throw new InvalidArgumentException("Invalid class name $name");
    }


    function __call($method, $args) {
        if($method == 'end') {
            $this->pop();
        } else {
            while(count($this->stack)) {
                $topOfStack = $this->peek();
                try {
                    $ret = call_user_func_array(array($topOfStack, $method), $args);
                    if(is_object($ret) && $ret !== $topOfStack) {
                        $this->push($ret);
                    }
                    break;
                } catch(BadMethodCallException $e) {
                    $this->pop();
                    if(!count($this->stack)) {
                        throw $e;
                    }
                } 
            }
        }
        return $this;
    }



    function push($node) {
        $this->stack[]= $node;
    }


    function pop() {
        return array_pop($this->stack);
    }


    function peek() {
        return end($this->stack);
    }


    function reset() {
        $this->stack = array(
            new \Mystique\PHP\Builder\PhpBuilder(new RootNode(), $this->namespace, $this->builderNamespace)
        );
    }

    function done() {
        $first = array_shift($this->stack);
        $this->reset();
        return $first->getSubject();
    }
}