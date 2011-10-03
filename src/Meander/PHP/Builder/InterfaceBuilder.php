<?php

namespace Meander\PHP\Builder;
use \Meander\PHP\Node\ClassNode;

class InterfaceBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'method' => array('addMember', 'MethodDefinition', 'MethodBuilder'),
        'property' => array('addMember', 'PropertyDefinition', 'PropertyBuilder'),
        'ext' => array('setExtends'),
    );
}