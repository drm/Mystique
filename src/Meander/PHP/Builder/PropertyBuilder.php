<?php

namespace Meander\PHP\Builder;

class PropertyBuilder extends BuilderAbstract {
    protected $methodMap = array(
        'value' => array('setDefaultValue', 'Value'),
    );
}