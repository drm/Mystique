<?php
namespace Meander\PHP\Builder;


class PhpBuilder extends BuilderAbstract
{
    protected function initBuilder()
    {
        $nameparser = new \Meander\PHP\Parser\NameParser();
        $nameparserCallback = function($string) use($nameparser) {
            return $nameparser->parse(new \Meander\PHP\Token\TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($string)));
        };
        $this->methodMap = array(
            'cls' => new MethodMapper('add', 'ClassNode', 'ClassBuilder', new ParameterMapper(array($nameparserCallback))),
            'fn' => new MethodMapper('add', 'FunctionNode', 'FunctionBuilder', new ParameterMapper(array($nameparserCallback))),
            'iface' => new MethodMapper('add', 'InterfaceNode', 'InterfaceBuilder', new ParameterMapper(array($nameparserCallback))),
        );
    }
}