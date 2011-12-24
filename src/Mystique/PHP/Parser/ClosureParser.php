<?php

namespace Mystique\PHP\Parser;

use \Mystique\PHP\Token\TokenStream;

class ClosureParser extends FunctionParser {
    function parse(TokenStream $stream)
    {
        $ret = new \Mystique\PHP\Node\ClosureNode();
        $ret->startTokenContext($stream);
        $stream->expect(T_FUNCTION);
        $ret->setParameters($this->parseParameterList($stream));
        $useList = new \Mystique\PHP\Node\UseList();
        if($stream->match(T_USE)) {
            $stream->next();
            $stream->expect('(');
            do {
                $var = $stream->expect(T_VARIABLE);
                $useList->add(new \Mystique\PHP\Node\Variable(substr($var->value, 1)));
                if($haveMore = $stream->match(',')) {
                    $stream->expect(',');
                }
            } while($haveMore);
            $stream->expect(')');
        }
        $ret->setUse($useList);

        $stream->expect('{');
        $ret->setDefinition($this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
        $stream->expect('}');
        $ret->endTokenContext($stream);
        return $ret;
    }

    function match(TokenStream $stream)
    {
        return ($stream->peek()->value == '(' && $stream->match(T_FUNCTION));
    }
}