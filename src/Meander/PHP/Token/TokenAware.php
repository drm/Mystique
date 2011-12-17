<?php

namespace Meander\PHP\Token;

use \Meander\PHP\Token\TokenStream;

interface TokenAware {
    function startTokenContext(TokenStream $stream);
    function endTokenContext(TokenStream $stream);
    function getTokenSlice();
}