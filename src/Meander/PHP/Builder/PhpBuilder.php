<?php
namespace Meander\PHP\Builder;


class PhpBuilder extends BuilderAbstract
{
    protected $methodMap = array(
        'cls' => array('add', 'ClassNode', 'ClassBuilder'),
        'fn' => array('add', 'FunctionNode', 'FunctionBuilder'),
        'iface' => array('add', 'InterfaceNode', 'InterfaceBuilder'),
    );
}