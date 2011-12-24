<?php

namespace Mystique\PHP\Builder;

class ParameterMapper {
    function __construct(array $callbacks = array()) {
        $this->callbacks = $callbacks;
    }


    function map($arguments) {
        foreach($arguments as $i => $argument) {
            if(isset($this->callbacks[$i])) {
                if(!is_callable($this->callbacks[$i])) {
                    throw new \RuntimeException(
                        'Invalid callback: '
                        . (is_object($this->callbacks[$i]) ? get_class($this->callbacks[$i]) : gettype($this->callbacks[$i]))
                    );
                }
                $arguments[$i] = call_user_func($this->callbacks[$i], $argument);
            }
        }
        return $arguments;
    }
}
