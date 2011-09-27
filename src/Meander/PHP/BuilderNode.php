<?php

namespace Meander\PHP;


class BuilderNode 
{
    protected $descendMethods = array();

    function __construct(Builder $builder, BuilderNode $parentNode, $innerObject)
    {
        $this->_builder = $builder;
        $this->_parentNode = $parentNode;
        $this->_innerObject = $innerObject;
    }


    function __call($method, $args) {
        call_user_func_array(array($this->_innerObject, $method), $args);
        return $this;
    }


    function end()
    {
        return $this->_parentNode;
    }
}