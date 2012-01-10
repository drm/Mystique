<?php

namespace Mystique\Common\Token;

interface Tokenizer {
    /**
     * @return \Mystique\Common\Token\TokenStream
     */
    function getTokens($source);
}