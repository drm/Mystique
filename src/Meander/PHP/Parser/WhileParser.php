<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\WhileNode;

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