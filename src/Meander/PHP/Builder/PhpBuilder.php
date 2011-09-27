<?php
namespace Meander\PHP\Builder;


class PhpBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'cls' => array('add', 'ClassDefinition', 'ClassBuilder'),
        'fn' => array('add', 'FunctionDefinition', 'FunctionBuilder'),
        'iface' => array('add', 'InterfaceDefinition', 'InterfaceBuilder'),
    );
}