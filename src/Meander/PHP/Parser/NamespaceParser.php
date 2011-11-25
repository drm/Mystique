<?php
namespace Meander\PHP\Parser;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\NamespaceNode;

class NamespaceParser extends ParserSub {
    function parse(TokenStream $stream) {
        $stream->expect(T_NAMESPACE);

        $def = new NamespaceNode();

        // global namespace
        if($stream->match('{')) {
            $stream->next();
            $def->setDefinition($this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
            $stream->expect('}');
        } else {
            $ns = $this->parent->parseName($stream);
            $def->setNamespace($ns);
            // file declaration
            if($stream->match(';')) {
                $stream->next();
            } else {
                // scoped declaration
                $stream->expect('{');
                $def->setDefinition($this->parent->subparse($stream, function($stream) { return $stream->match('}'); }));
                $stream->expect('}');
            }
        }
        return $def;
    }

    function match(TokenStream $stream) {
        return $stream->match(T_NAMESPACE);
    }
}