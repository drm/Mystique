<?php

namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\Raw;
use \Mystique\PHP\Node\Php;
use \Mystique\PHP\Parser\UseParser;


class PhpParser extends ParserBase {
    function __construct() {
        parent::__construct();

        $this->parsers = array(
            'class'         => new ClassParser($this),
            'interface'     => new InterfaceParser($this),
            'function'      => new FunctionParser($this),
            'namespace'     => new NamespaceParser($this),
            'compound'      => new CompoundStatementParser($this),
            'try'           => new TryCatchParser($this),
            'if'            => new IfParser($this),
            'for'           => new ForParser($this),
            'foreach'       => new ForeachParser($this),
            'switch'        => new SwitchParser($this),
            'while'         => new WhileParser($this),
            'do'            => new DoWhileParser($this),
            'constructs'    => new LanguageConstructParser($this),
            'statement'     => new StatementParser($this),
            'use'           => new UseParser($this)
        );
    }

    function parse(TokenStream $stream) {
        $ret = new Php();
        $ret->startTokenContext($stream);
        $stream->expect(T_OPEN_TAG);
        if($stream->match(T_STRING, 'php')) { // TODO check if this is really ok :?
            $stream->next();
        }
        $php = $this->subparse($stream, function($stream) { return !$stream->valid() || $stream->match(T_CLOSE_TAG); });
        if($stream->valid()) {
            $stream->expect(T_CLOSE_TAG);
        }
        $ret->children = $php;
        $ret->endTokenContext($stream);
        return $ret;
    }

    function match(TokenStream $stream) {
        return $stream->match(T_OPEN_TAG);
    }
}