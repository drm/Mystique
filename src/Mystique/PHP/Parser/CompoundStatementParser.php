<?php

namespace Mystique\PHP\Parser;

use \Mystique\PHP\Node\CompoundStatement;
use \Mystique\Common\Token\TokenStream;
use Mystique\Common\Parser\Parser;


class CompoundStatementParser extends StatementParser implements Parser {
    function parse(TokenStream $stream) {
        $stream->expect('{');
        $contents = $this->parent->subparse($stream, function($stream) { return $stream->match('}'); });
        $stream->expect('}');
        return new CompoundStatement($contents);
    }

    function match(TokenStream $stream) {
        return $stream->match('{');
    }
}