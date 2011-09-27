<?php

namespace Meander\PHP\Parser;
use \Meander\PHP\Node\NodeList;

use \Meander\PHP\Node\CompoundStatement;
use \Meander\PHP\Token\TokenStream;

class CompoundStatementParser extends StatementParser implements Parser {
    function parse(TokenStream $stream) {
        $stream->expect('{');
        $contents = $this->parent->subparse($stream, array($this, 'decideEnd'));
        $stream->expect('}');
        return new CompoundStatement($contents);
    }

    function decideEnd(TokenStream $stream) {
        return $stream->match('}');
    }

    function match(TokenStream $stream) {
        return $stream->match('{');
    }
}