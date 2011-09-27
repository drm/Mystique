<?php

namespace Meander\PHP\Parser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\NamespaceDeclaration;

class NamespaceParser extends StatementParser implements Parser {
    
    function parse(TokenStream $stream) {
        $stream->expect(T_NAMESPACE);

        $ns = $this->parent->parseExpression($stream);
        if($stream->match(';')) {
            $stream->next();
            return new NamespaceDeclaration($ns);
        } else {
            throw new \LogicException("Unimplemented");
        }
    }

    function match(TokenStream $stream) {
        return $stream->match(T_NAMESPACE);
    }
}