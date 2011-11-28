<?php

namespace Meander\PHP\Builder;

use \Meander\PHP\Token\Tokenizer;
use \Meander\PHP\Token\TokenStream;

class DefaultInputParser implements InputParser {
    function __construct() {
        $this->expressionParser = new \Meander\PHP\Parser\ExpressionParser();
    }


    function parseValue($input)
    {
        return $this->expressionParser->parse($this->_tokenize($input));
    }

    function parseName($input)
    {
        return $this->expressionParser->parseName($this->_tokenize($input));
    }

    protected function _tokenize($input) {
        return new TokenStream(\Meander\PHP\Token\Tokenizer::tokenizePhp($input));
    }
}