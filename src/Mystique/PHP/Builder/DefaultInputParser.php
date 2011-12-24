<?php

namespace Mystique\PHP\Builder;

use \Mystique\PHP\Token\Tokenizer;
use Mystique\Common\Token\TokenStream;

class DefaultInputParser implements InputParser {
    function __construct() {
        $this->expressionParser = new \Mystique\PHP\Parser\ExpressionParser();
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
        return new TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($input));
    }
}