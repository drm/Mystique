<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;

class ClosureParser extends FunctionParser {
    function parse(TokenStream $stream)
    {
        $ret = new \Meander\PHP\Node\ClosureNode();
        $stream->expect(T_FUNCTION);
        $ret->setParameters($this->parseParameterList($stream));
        $useList = new \Meander\PHP\Node\UseList();
        if($stream->match(T_USE)) {
            $stream->next();
            $stream->expect('(');
            do {
                $var = $stream->expect(T_VARIABLE);
                $useList->add(new \Meander\PHP\Node\Variable(substr($var->value, 1)));
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
        return $ret;
    }

    function match(TokenStream $stream)
    {
        return ($stream->peek()->value == '(' && $stream->match(T_FUNCTION));
    }
}