<?php

namespace Mystique\PHP\Formatter;

use \Mystique\PHP\Token\Tokenizer;
use \Mystique\PHP\Token\TokenStream;

class Deflate implements FormatterInterface {
    function __construct($stripComments = true) {
        $this->stripComments = $stripComments;
    }


    function format($code) {
        $compiler = new \Mystique\Compiler\Compiler();
        foreach(new TokenStream(Tokenizer::tokenize($code)) as $token) {
            if($this->stripComments && in_array($token->type, array(T_COMMENT, T_DOC_COMMENT))) {
                continue;
            }
            if($token->type != T_WHITESPACE) {
                $compiler->write($token->value);
            }
        }
        return $compiler->result;
    }
}