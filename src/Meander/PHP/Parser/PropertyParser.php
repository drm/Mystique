<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;

class PropertyParser extends ParserSub {
    function parse(TokenStream $stream)
    {
        $def = new \Meander\PHP\Node\PropertyDefinition();
        while($stream->match(array(T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED))) {
            switch($stream->current()->type) {
                case T_STATIC:
                    $def->setStatic(true);
                    break;
                case T_PUBLIC:
                    $def->setVisibility(\Meander\PHP\Node\MethodDeclaration::IS_PUBLIC);
                    break;
                case T_PRIVATE:
                    $def->setVisibility(\Meander\PHP\Node\MethodDeclaration::IS_PRIVATE);
                    break;
                case T_PROTECTED:
                    $def->setVisibility(\Meander\PHP\Node\MethodDeclaration::IS_PROTECTED);
                    break;
            }
            $stream->next();
        }
        $name = substr($stream->expect(T_VARIABLE)->value, 1);
        $def->setName($name);
        if($stream->match('=')) {
            $stream->next();
            $def->setDefaultValue($this->parent->getExpressionParser()->parse($stream));
        }
        $stream->expect(';');

        return $def;
    }

    function match(TokenStream $stream)
    {
        return $stream->matchSignature(T_VARIABLE, null, array(T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED));
    }
}