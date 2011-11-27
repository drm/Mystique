<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Statement;

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
                \Meander\PHP\Token\Operator::$unaryOperators,
                ExpressionParser::$functionLikeConstructs,
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