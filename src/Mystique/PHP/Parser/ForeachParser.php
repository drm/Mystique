<?php
namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\ForeachNode;
use Mystique\Common\Parser\ParserSub;

class ForeachParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_FOREACH);
        $stream->expect('(');
        $expressions[0] = $this->parent->parseExpression($stream);
        $stream->expect(T_AS);
        $expressions[1]= $this->parent->parseExpression($stream);
        $stream->expect(')');
        return new ForeachNode($expressions, $this->parent->subparse($stream, true)->peek());
    }

    function match(TokenStream $stream)
    {
        return $stream->match(T_FOREACH);
    }
}