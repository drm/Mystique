<?php

namespace Mystique\PHP\Builder;

class FunctionBuilder extends BuilderAbstract
{
    protected function initBuilder()
    {
        $this->methodMap = array(
            'param' => new MethodMapper('addParameter', 'ParameterDefinition', 'ParameterBuilder'),
            'raw' => new MethodMapper('setBody', 'Raw')
        );
    }
}