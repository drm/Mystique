<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Raw;
use \Meander\PHP\Node\Php;
use \Meander\PHP\Parser\UseParser;


class PhpParser extends ParserBase {
    function __construct() {
        parent::__construct();

        $this->parsers = array(
            'class'         => new ClassParser($this),
            'function'      => new FunctionParser($this),
            'namespace'     => new NamespaceParser($this),
            'compound'      => new CompoundStatementParser($this),
            'if'            => new IfParser($this),
            'constructs'    => new LanguageConstructParser($this),
            'statement'     => new StatementParser($this),
            'use'           => new UseParser($this)
        );
    }

    function parse(TokenStream $stream) {
        $stream->expect(T_OPEN_TAG);
        if($stream->match(T_STRING, 'php')) { // TODO check if this is really ok :?
            $stream->next();
        }
        $php = $this->subparse($stream, array($this, 'decideEnd'));
        if($stream->valid()) {
            $stream->expect(T_CLOSE_TAG);
        }
        return new Php($php);
    }

    function decideEnd(TokenStream $stream) {
        if(!$stream->valid()) {
            return true;
        }
        return $stream->match(T_CLOSE_TAG);
    }

    function match(TokenStream $stream) {
        return $stream->match(T_OPEN_TAG);
    }
}