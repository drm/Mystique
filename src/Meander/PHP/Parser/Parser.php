<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;

interface Parser {
    function parse(TokenStream $stream);
    function match(TokenStream $stream);
}