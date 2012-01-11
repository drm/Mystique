<?php

namespace Mystique\PHP\Token;

use Mystique\Common\Token\Tokenizer as BaseTokenizer;

class Tokenizer implements BaseTokenizer {
    static function tokenize($str) {
        return token_get_all($str);
    }

    static function tokenizePhp($str) {
        return array_slice(token_get_all('<?php ' . $str), 1);
    }

    /**
     * @return \Mystique\Common\Token\TokenStream
     */
    function getTokens($source, $ignore = array(T_DOC_COMMENT, T_COMMENT, T_WHITESPACE))
    {
        return new \Mystique\Common\Token\TokenStream(self::tokenize($source), $ignore);
    }
}