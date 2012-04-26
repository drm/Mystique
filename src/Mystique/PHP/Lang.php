<?php

namespace Mystique\PHP;
use Mystique\Common\LangAbstract;

class Lang extends LangAbstract {
    public static function tokenStreamPhp($input) {
        $t = new self();
        return $t->getTokenStream($input, null, '');
    }


    function getParser()
    {
        return new \Mystique\PHP\Parser\FileParser();
    }

    function getTokenizer()
    {
        return new \Mystique\PHP\Token\Tokenizer();
    }

    function getCompiler()
    {
        return new \Mystique\Common\Compiler\Compiler();
    }


    function getTokenStream($input, $ignore = null, $scope = 'root') {
        $ignore = $ignore ?: array(T_DOC_COMMENT, T_COMMENT, T_WHITESPACE);
        if($scope == 'root') {
            return new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenize($input), $ignore);
        } else {
            return new \Mystique\Common\Token\TokenStream(\Mystique\PHP\Token\Tokenizer::tokenizePhp($input), $ignore);
        }
    }
}