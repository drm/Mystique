<?php
namespace Meander\PHP\Builder;

use ReflectionClass,
    UnexpectedValueException,
    BadMethodCallException;

abstract class BuilderAbstract {
    protected $subject;
    protected $namespace;
    protected $methodMap = array();
    private $builderNamespace;

    final function __construct($subject, $namespace, $builderNamespace = '\Meander\PHP\Builder\\', InputParser $inputParser = null) {
        $this->inputParser = $inputParser ?: new DefaultInputParser();
        $this->subject = $subject;
        $this->namespace = $namespace;
        $this->builderNamespace = $builderNamespace;
        $this->initBuilder();
    }

    function __call($method, $args) {
        if(array_key_exists($method, $this->methodMap)) {
            $methodMapper = $this->methodMap[$method];

            if($methodMapper->parameterMapper) {
                $args = $methodMapper->parameterMapper->map($args);
            }

            if($methodMapper->class) {
                $className = $this->namespace . $methodMapper->class;
                if(!class_exists($className)) {
                    throw new UnexpectedValueException("Class $className does not exist!");
                }

                $refl = new ReflectionClass($className);
                $instance = $refl->newInstanceArgs($args);
                call_user_func(array($this->subject, $methodMapper->delegate), $instance);

                if($methodMapper->builderClass) {
                    $builderClass = $this->builderNamespace . $methodMapper->builderClass;
                    $builderRefl = new ReflectionClass($builderClass);
                    return $builderRefl->newInstance($instance, $this->namespace, $this->builderNamespace);
                }
            } else {
                call_user_func_array(array($this->subject, $methodMapper->delegate), $args);
            }
        } elseif(is_callable(array($this->subject, $method))) {
            call_user_func_array(array($this->subject, $method), $args);
        } else {
            throw new BadMethodCallException('invalid method ' . $method . ' in ' . get_class($this));
        }

        return $this;
    }


    function getSubject() {
        return $this->subject;
    }


    abstract protected function initBuilder();
}