<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\PairMatcher;
use \Meander\PHP\Node\ClassDefinition;
use \Meander\PHP\Node\Raw;

class ClassParser extends ParserBase
{
    function __construct()
    {
        parent::__construct();
        $this->parsers[]= new BlockParser('{');
    }


    /**
     * @var \Meander\PHP\Node\ClassDefinition
     */
    private $definition;

    function match(TokenStream $stream)
    {
        return $stream->matchSignature(T_CLASS, null, array(T_ABSTRACT, T_FINAL, T_DOC_COMMENT));
    }


    function parse(TokenStream $stream)
    {
        $this->definition = new ClassDefinition();
        while ($stream->match(array(T_ABSTRACT, T_FINAL, T_DOC_COMMENT))) {
            switch ($stream->current()->type) {
                case T_FINAL:
                    $this->definition->setFinal();
                    break;
                case T_ABSTRACT:
                    $this->definition->setAbstract();
                    break;
                case T_DOC_COMMENT:
                    $this->definition->setDoc($stream->current()->value);
                    break;
            }
            $stream->next();
        }
        $stream->expect(T_CLASS);
        $this->definition->setName($stream->expect(T_STRING)->value);
        if ($stream->match(T_EXTENDS)) {
            $stream->next();
            $this->definition->setExtends($stream->expect(T_STRING)->value);
        }
        if ($stream->match(T_IMPLEMENTS)) {
            $implements = array();
            do {
                $stream->next();
                $implements[] = $stream->expect(T_STRING)->value;
            } while ($stream->match(','));
            $this->definition->addImplements($implements);
        }
        $this->definition->setRawBody($this->subparse($stream, true));
        return $this->definition;
    }
}