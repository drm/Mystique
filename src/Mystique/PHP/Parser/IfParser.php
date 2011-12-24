<?php
namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\IfNode;

class IfParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_IF);
        $stream->expect('(');
        $expression = $this->parent->parseExpression($stream);
        $stream->expect(')');
        $ret = new IfNode($expression, $this->parent->subparse($stream, true)->peek());

        while($stream->valid() && $stream->match(T_ELSEIF)) {
            $stream->next();
            $stream->expect('(');
            $expr = $this->parent->parseExpression($stream);
            $stream->expect(')');
            $ret->children->append(new \Mystique\PHP\Node\ElseifNode($expr, $this->parent->subparse($stream, true)->peek()));
        }

        if($stream->valid() && $stream->match(T_ELSE)) {
            $stream->next();
            $ret->children->append(new \Mystique\PHP\Node\ElseNode($this->parent->subparse($stream, true)));
        }
        
        return $ret;
    }

    function match(TokenStream $stream) {
        return $stream->match(T_IF);
    }

}