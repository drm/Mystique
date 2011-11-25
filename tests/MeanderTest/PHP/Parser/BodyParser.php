<?php
namespace MeanderTest\PHP\Parser;
use \Meander\PHP\Token\TokenStream;

class BodyParser extends \Meander\PHP\Parser\ParserBase {
    function __construct()
    {
        parent::__construct();
        $this->parsers[]= new \Meander\PHP\Parser\BlockParser('{');
    }

    function parse(TokenStream $stream)
    {
    }

    function match(TokenStream $stream)
    {
    }
}

