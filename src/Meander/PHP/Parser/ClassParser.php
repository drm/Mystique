<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\PairMatcher;
use \Meander\PHP\Node\ClassNode;
use \Meander\PHP\Node\Raw;

class ClassParser extends ParserBase
{
    function __construct(ParserBase $parent)
    {
        parent::__construct();
        $this->parsers[]= new MethodParser($parent);
        $this->parsers[]= new PropertyParser($parent);
        $this->parsers[]= new ConstantParser($parent);
    }


    function match(TokenStream $stream)
    {
        return $stream->matchSignature(T_CLASS, null, array(T_ABSTRACT, T_FINAL, T_DOC_COMMENT));
    }


    function parse(TokenStream $stream)
    {
        $definition = new ClassNode();
        while ($stream->match(array(T_ABSTRACT, T_FINAL, T_DOC_COMMENT))) {
            switch ($stream->current()->type) {
                case T_FINAL:
                    $definition->setFinal();
                    break;
                case T_ABSTRACT:
                    $definition->setAbstract();
                    break;
                case T_DOC_COMMENT:
                    $definition->setDoc($stream->current()->value);
                    break;
            }
            $stream->next();
        }
        $stream->expect(T_CLASS);
        $definition->setName(new \Meander\PHP\Node\Name($stream->expect(T_STRING)->value));
        if ($stream->match(T_EXTENDS)) {
            $stream->next();
            $definition->addExtends($this->getExpressionParser()->parseName($stream));
        }
        if ($stream->match(T_IMPLEMENTS)) {
            do {
                $stream->next();
                $definition->addImplements(new \Meander\PHP\Node\Name($stream->expect(T_STRING)->value));
            } while ($stream->match(','));
        }
        $stream->expect('{');
        $definition->setDefinition($this->subparse($stream, function($stream) { return $stream->match('}'); }));
        $stream->expect('}');
        return $definition;
    }
}