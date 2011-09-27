<?php

namespace Meander\PHP\Parser;
use \Meander\PHP\Token\TokenStream;

class FileParser extends \Meander\PHP\Parser\ParserBase {
    function __construct() {
        parent::__construct();
        $this->parsers[] = new PhpParser();
        $this->parsers[] = new HtmlParser();
    }


    function parse(TokenStream $stream) {
        $this->subparse($stream, false);
    }


    function match(TokenStream $stream) {
        return true;
    }
}