<?php
namespace Meander\PHP\Builder;

use ReflectionClass,
    UnexpectedValueException,
    BadMethodCallException;

class BuilderAbstract {
    protected $subject;
    protected $namespace;
    protected $methodMap = array();
    private $builderNamespace;

    function __construct($subject, $namespace, $builderNamespace = '\Meander\PHP\Builder\\') {
        $this->subject = $subject;
        $this->namespace = $namespace;
        $this->builderNamespace = $builderNamespace;
    }

    function __call($method, $args) {
        if(array_key_exists($method, $this->methodMap)) {
            @list($delegate, $class, $builderClass) = $this->methodMap[$method];

            if($class) {
                $className = $this->namespace . $class;
                if(!class_exists($className)) {
                    throw new UnexpectedValueException("Class $className does not exist!");
                }

                $refl = new ReflectionClass($className);
                $instance = $refl->newInstanceArgs($args);
                call_user_func(array($this->subject, $delegate), $instance);
                
                if($builderClass) {
                    $builderClass = $this->builderNamespace . $builderClass;
                    $builderRefl = new ReflectionClass($builderClass);
                    return $builderRefl->newInstance($instance, $this->namespace, $this->builderNamespace);
                }
            } else {
                call_user_func_array(array($this->subject, $delegate), $args);
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
}