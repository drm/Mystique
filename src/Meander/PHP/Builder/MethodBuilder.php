<?php

namespace Meander\PHP\Builder;
use \Meander\PHP\Node\ClassDefinition;

class MethodBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'param' => array('addParameter', 'ParameterDefinition', 'ParameterBuilder'),
        'raw' => array('setBody', 'Raw')
    );
}