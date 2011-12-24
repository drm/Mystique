<?php
namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\WhileNode;
use Mystique\Common\Parser\ParserSub;

class WhileParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_WHILE);
        $stream->expect('(');
        $expression = $this->parent->parseExpression($stream);
        $stream->expect(')');
        return new WhileNode($expression, $this->parent->subparse($stream, true)->peek());
    }

    function match(TokenStream $stream)
    {
        return $stream->match(array(T_WHILE));
    }
}