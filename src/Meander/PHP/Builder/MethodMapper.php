<?php

namespace Meander\PHP\Builder;

class MethodMapper {
    function __construct($delegate, $class = null, $builderClass = null, $parameterMapper = null) {
        $this->delegate = $delegate;
        $this->class = $class;
        $this->builderClass = $builderClass;
        $this->parameterMapper = $parameterMapper;
    }
}