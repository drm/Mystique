<?php

namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Token\PairMatcher;
use \Meander\PHP\Node\InterfaceNode;
use \Meander\PHP\Node\Raw;

class InterfaceParser extends ParserBase
{
    function __construct($parent)
    {
        parent::__construct();
        $this->parsers[]= new MethodParser($parent);
        $this->parsers[]= new PropertyParser($parent);
        $this->parsers[]= new ConstantParser($parent);
    }


    function match(TokenStream $stream)
    {
        return $stream->match(T_INTERFACE);
    }


    function parse(TokenStream $stream)
    {
        $node = new InterfaceNode();
        if ($stream->match(array(T_ABSTRACT, T_FINAL, T_DOC_COMMENT))) {
            $node->setDoc($stream->current()->value);
            $stream->next();
        }
        $stream->expect(T_INTERFACE);
        $node->setName(new \Meander\PHP\Node\Name($stream->expect(T_STRING)->value));
        if ($stream->match(T_EXTENDS)) {
            do {
                $stream->next();
                $node->addExtends($this->getExpressionParser()->parseName($stream));
            } while($stream->match(','));
        }
        $stream->expect('{');
        $node->setDefinition($this->subparse($stream, function($stream) { return $stream->match('}'); }));
        $stream->expect('}');
        return $node;
    }
}