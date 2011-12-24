<?php

namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use \Mystique\PHP\Node\InterfaceNode;
use Mystique\Common\Parser\ParserBase;
use \Mystique\PHP\Node\Raw;

class InterfaceParser extends ParserBase
{
    function __construct(ParserBase $parent)
    {
        parent::__construct($parent->getExpressionParser());
        $this->parsers[]= new InterfaceMethodParser($parent);
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
        $node->setName(new \Mystique\PHP\Node\Name($stream->expect(T_STRING)->value));
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