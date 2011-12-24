<?php

namespace Mystique\PHP\Parser;
use \Mystique\Common\Token\TokenStream;
use Mystique\Common\Parser\ParserBase;

class FileParser extends ParserBase {
    function __construct() {
        parent::__construct();
        $this->parsers[] = new PhpParser();
        $this->parsers[] = new HtmlParser();
    }


    function parse(TokenStream $stream) {
        return $this->subparse($stream, function(){ return false; });
    }


    function match(TokenStream $stream) {
        return true;
    }
}