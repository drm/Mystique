<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\TryCatchNode;

class TryCatchParser extends ParserSub {
    function parse(TokenStream $stream) {
        $ret = new TryCatchNode();
        
        $stream->expect(T_TRY);
        $stream->expect('{');
        $ret->setTry($this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
        $stream->expect('}');

        while($stream->valid() && $stream->match(T_CATCH)) {
            $stream->next();
            $stream->expect('(');
            $eName = $this->parent->getExpressionParser()->parseName($stream);
            $eValue = new \Meander\PHP\Node\Variable(substr($stream->expect(T_VARIABLE)->value, 1));
            $stream->expect(')');
            $stream->expect('{');
            $ret->addCatch($eName, $eValue, $this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
            $stream->expect('}');
        }

        return $ret;
    }

    function match(TokenStream $stream) {
        return $stream->match(T_TRY);
    }
}