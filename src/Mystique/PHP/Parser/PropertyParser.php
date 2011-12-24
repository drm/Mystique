<?php
namespace Mystique\PHP\Parser;

use \Mystique\Common\Token\TokenStream;
use Mystique\Common\Ast\Node\NodeList;

class PropertyParser extends ParserSub
{
    function parse(TokenStream $stream)
    {
        $ret = new \Mystique\PHP\Node\PropertyNode();
        while ($stream->match(array(T_STATIC, T_PUBLIC, T_PRIVATE, T_PROTECTED))) {
            switch ($stream->current()->type) {
                case T_STATIC:
                    $ret->setStatic(true);
                    break;
                case T_PUBLIC:
                    $ret->setVisibility(\Mystique\PHP\Node\MemberDeclarationAbstract::IS_PUBLIC);
                    break;
                case T_PRIVATE:
                    $ret->setVisibility(\Mystique\PHP\Node\MemberDeclarationAbstract::IS_PRIVATE);
                    break;
                case T_PROTECTED:
                    $ret->setVisibility(\Mystique\PHP\Node\MemberDeclarationAbstract::IS_PROTECTED);
                    break;
            }
            $stream->next();
        }
        

        $definitions = new NodeList();
        do {
            $name = substr($stream->expect(T_VARIABLE)->value, 1);
            $def = new \Mystique\PHP\Node\PropertyDefinition();
            $def->setName(new \Mystique\PHP\Node\Variable($name));
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