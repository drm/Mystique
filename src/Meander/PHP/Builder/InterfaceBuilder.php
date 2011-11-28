<?php

namespace Meander\PHP\Builder;
use \Meander\PHP\Node\ClassNode;

class InterfaceBuilder extends BuilderAbstract
{
    protected function initBuilder()
    {
        $this->methodMap = array(
            'method' => new MethodMapper('addMember', 'MethodDefinition', 'MethodBuilder'),
            'property' => new MethodMapper('addMember', 'PropertyDefinition', 'PropertyBuilder'),
            'ext' => new MethodMapper('addExtends', null, null, new ParameterMapper(array(array($this->inputParser, 'parseName')))),
        );
    }
}