<?php

namespace Mystique\PHP\Parser;

use \Mystique\PHP\Node\SwitchNode;
use \Mystique\PHP\Node\CaseNode;
use \Mystique\PHP\Node\CaseDefaultNode;
use \Mystique\PHP\Token\TokenStream;

class SwitchParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_SWITCH);
        $stream->expect('(');
        $expression = $this->parent->parseExpression($stream);
        $stream->expect(')');
        $stream->expect('{');


        $cases = array();
        do {
            $expr = null;
            $token = $stream->expect(array(T_CASE, T_DEFAULT));

            if($token->type != T_DEFAULT) {
                $expr = $this->parent->parseExpression($stream);
            }
            $stream->expect(':');
            $body = new \Mystique\PHP\Node\CaseBody($this->parent->subparse($stream, function(TokenStream $stream) {
                return $stream->match(array('}', T_CASE, T_DEFAULT));
            }));
            if(is_null($expr)) {
                $cases[] = new CaseDefaultNode($body);
            } else {
                $cases[] = new CaseNode($expr, $body);
            }
        } while(!$stream->match('}'));
        $stream->expect('}');

        return new SwitchNode(
            $expression,
            $cases
        );
    }

    function match(TokenStream $stream) {
        return $stream->match(T_SWITCH);
    }
}