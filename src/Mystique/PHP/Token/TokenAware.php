<?php

namespace Mystique\PHP\Token;

use \Mystique\PHP\Token\TokenStream;

interface TokenAware {
    function startTokenContext(TokenStream $stream);
    function endTokenContext(TokenStream $stream);
    function getTokenSlice();
}