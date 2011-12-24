<?php

namespace Mystique\PHP\Parser;

use \Mystique\PHP\Token\TokenStream;

class ConstantParser extends ParserSub {
    function parse(TokenStream $stream)
    {
        $stream->expect(T_CONST);
        $ret = new \Mystique\PHP\Node\ConstantDefinition();
        $ret->setName($this->parent->getExpressionParser()->parseName($stream));
        $stream->expect('=');
        $ret->setValue($this->parent->getExpressionParser()->parse($stream));
        $stream->expect(';');
        return $ret;
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_CONST);
    }
}