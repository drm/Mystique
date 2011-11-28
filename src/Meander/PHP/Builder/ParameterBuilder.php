<?php
namespace Meander\PHP\Builder;

class ParameterBuilder extends BuilderAbstract {
    protected function initBuilder()
    {
        $this->methodMap = array(
            'value' => new MethodMapper('setDefaultValue', null, null, new ParameterMapper(array(array($this->inputParser, 'parseValue')))),
            'type' => new MethodMapper('setTypeHint', null, null, new ParameterMapper(array(array($this->inputParser, 'parseName'))))
        );
    }
}