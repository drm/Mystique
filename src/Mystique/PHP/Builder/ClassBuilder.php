<?php

namespace Mystique\PHP\Builder;
use \Mystique\PHP\Node\ClassNode;

class ClassBuilder extends BuilderAbstract
{
    protected function initBuilder()
    {
        $this->methodMap = array(
            'method'        => new MethodMapper('addMember', 'MethodNode', 'MethodBuilder'),
            'property'      => new MethodMapper('addMember', 'PropertyDefinition', 'PropertyBuilder'),
            'ext'           => new MethodMapper('setExtends', null, null, new ParameterMapper(array(array($this->inputParser, 'parseName')))),
            'impl'          => new MethodMapper('addImplements', null, null, new ParameterMapper(array(array($this->inputParser, 'parseName')))),
        );
    }
}