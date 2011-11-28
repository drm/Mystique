<?php

namespace Meander\PHP\Builder;

class PropertyBuilder extends BuilderAbstract {
    protected function initBuilder()
    {
        $this->methodMap = array(
            'value' => new MethodMapper('setDefaultValue', null, null, new ParameterMapper(array(array($this->inputParser, 'parseValue')))),
        );
    }
}