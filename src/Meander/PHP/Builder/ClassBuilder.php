<?php

namespace Meander\PHP\Builder;
use \Meander\PHP\Node\ClassNode;

class ClassBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'method' => array('addMember', 'MethodNode', 'MethodBuilder'),
        'property' => array('addMember', 'PropertyDefinition', 'PropertyBuilder'),
        'ext' => array('setExtends'),
        'impl' => array('addImplements'),
        'setAbstract' => array('setAbstract'),
        'setFinal' => array('setFinal')
    );
}