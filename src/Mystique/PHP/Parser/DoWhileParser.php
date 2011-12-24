<?php
namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\DoWhileNode;
use Mystique\Common\Parser\ParserSub;

class DoWhileParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_DO);
        $body = $this->parent->subparse($stream, true)->peek();
        $stream->expect(T_WHILE);
        $stream->expect('(');
        $expression = $this->parent->parseExpression($stream);
        $stream->expect(')');
        return new DoWhileNode($expression, $body);
    }

    function match(TokenStream $stream)
    {
        return $stream->match(array(T_DO));
    }
}