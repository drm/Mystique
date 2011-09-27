<?php

namespace Meander\PHP\Builder;

class FunctionBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'param' => array('addParameter', 'ParameterDefinition', 'ParameterBuilder'),
    );
}