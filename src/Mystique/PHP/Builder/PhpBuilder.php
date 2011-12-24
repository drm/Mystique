<?php
namespace Mystique\PHP\Builder;


class PhpBuilder extends BuilderAbstract
{
    protected function initBuilder()
    {
        $nameparser = new \Mystique\PHP\Parser\NameParser();
        $nameparserCallback = function($string) use($nameparser) {
            return $nameparser->parse(new \Mystique\PHP\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($string)));
        };
        $this->methodMap = array(
            'cls' => new MethodMapper('add', 'ClassNode', 'ClassBuilder', new ParameterMapper(array($nameparserCallback))),
            'fn' => new MethodMapper('add', 'FunctionNode', 'FunctionBuilder', new ParameterMapper(array($nameparserCallback))),
            'iface' => new MethodMapper('add', 'InterfaceNode', 'InterfaceBuilder', new ParameterMapper(array($nameparserCallback))),
        );
    }
}