<?php

namespace Mystique\PHP\Parser;

use \Mystique\PHP\Token\TokenStream;
use \Mystique\PHP\Node\Statement;

class StatementParser extends ParserSub {
    function parse(TokenStream $stream) {
        if($stream->match(';')) {
            $stream->next();
            return new Statement(null);
        }
        $ret = new Statement($this->parent->parseExpression($stream));;
        if($stream->valid()) {
            $stream->expect(array(';', T_CLOSE_TAG));
        }

        return $ret;
    }

    function match(TokenStream $stream) {
        return $stream->match(
            array_merge(
                \Mystique\PHP\Token\Operator::$unaryOperators,
                NameParser::$functionLikeConstructs,
                array(
                    T_STRING,
                    T_VARIABLE,
                    T_NS_SEPARATOR,
                    ';',
                )
            )
        );
    }
}