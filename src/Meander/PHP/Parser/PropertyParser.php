<?php
namespace Meander\PHP\Parser;

use \Meander\PHP\Token\TokenStream;

class PropertyParser extends ParserSub
{
    function parse(TokenStream $stream)
    {
        $ret = new \Meander\PHP\Node\PropertyNode();
        while ($stream->match(array(T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED))) {
            switch ($stream->current()->type) {
                case T_STATIC:
                    $ret->setStatic(true);
                    break;
                case T_PUBLIC:
                    $ret->setVisibility(\Meander\PHP\Node\MemberDeclarationAbstract::IS_PUBLIC);
                    break;
                case T_PRIVATE:
                    $ret->setVisibility(\Meander\PHP\Node\MemberDeclarationAbstract::IS_PRIVATE);
                    break;
                case T_PROTECTED:
                    $ret->setVisibility(\Meander\PHP\Node\MemberDeclarationAbstract::IS_PROTECTED);
                    break;
            }
            $stream->next();
        }
        

        $definitions = new \Meander\PHP\Node\NodeList();
        do {
            $name = substr($stream->expect(T_VARIABLE)->value, 1);
            $def = new \Meander\PHP\Node\PropertyDefinition();
            $def->setName(new \Meander\PHP\Node\Variable($name));
            if ($stream->match('=')) {
                $stream->next();
                $def->setDefaultValue($this->parent->getExpressionParser()->parse($stream));
            }
            $definitions->append($def);
        } while ($stream->match(',') && $stream->expect(','));

        $ret->setDefinition($definitions);

        $stream->expect(';');
        return $ret;
    }

    function match(TokenStream $stream)
    {
        return $stream->matchSignature(T_VARIABLE, null, array(T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED));
    }
}