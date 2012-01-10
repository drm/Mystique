<?php

namespace Mystique\PHP;
use Mystique\Common\LangAbstract;

class Lang extends LangAbstract {
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
}