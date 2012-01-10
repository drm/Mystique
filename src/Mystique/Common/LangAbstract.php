<?php

namespace Mystique\Common;


abstract class LangAbstract implements Lang {
    final function parseFile($fileName) {
        $parser = $this->getParser();
        $stream = $this->getTokenizer()->getTokens(file_get_contents($fileName));
        $stream->setFilename($fileName);
        return $parser->parse($stream);
    }
}