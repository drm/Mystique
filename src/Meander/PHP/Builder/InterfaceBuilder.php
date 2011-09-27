<?php

namespace Meander\PHP\Builder;
use \Meander\PHP\Node\ClassDefinition;

class InterfaceBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'method' => array('addMember', 'MethodDefinition', 'MethodBuilder'),
        'property' => array('addMember', 'PropertyDefinition', 'PropertyBuilder'),
        'ext' => array('setExtends'),
    );
}