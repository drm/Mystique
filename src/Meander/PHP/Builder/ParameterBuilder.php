<?php
namespace Meander\PHP\Builder;

class ParameterBuilder extends BuilderAbstract {
    protected $methodMap = array(
        'value' => array('setDefaultValue', 'Value'),
        'type' => array('setTypeHint', 'Name')
    );
}