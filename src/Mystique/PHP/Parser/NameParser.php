<?php
namespace Mystique\PHP\Parser;

use \Mystique\PHP\Node\Name;
use \Mystique\PHP\Node\NamespacedName;
use Mystique\Common\Token\TokenStream;

class NameParser implements Parser {
    public static $functionLikeConstructs = array(
        T_ARRAY, T_LIST, T_EMPTY, T_ISSET, T_DECLARE, T_UNSET, T_INCLUDE, T_EVAL
    );

    public static $constants = array(
        T_FUNC_C, T_DIR, T_FILE, T_LINE, T_METHOD_C, T_CLASS_C
    );

    function parse(TokenStream $stream)
    {
        $namespace = array();
        if ($stream->match(self::$functionLikeConstructs)) {
            $value = new Name($stream->expect(self::$functionLikeConstructs)->value);
        } elseif ($stream->match(self::$constants)) {
            $value = new Name($stream->current()->value);
            $stream->next();
        } else {
            if ($stream->match(T_NS_SEPARATOR)) {
                $namespace[] = $stream->current()->value;
                $stream->next();
            }
            $namespace[] = $stream->expect(T_STRING)->value;
            while ($stream->valid() && $stream->match(array(T_NS_SEPARATOR))) {
                $namespace[] = $stream->current()->value;
                $stream->next();
                $namespace[] = $stream->expect(T_STRING)->value;
            }
            $name = array_pop($namespace);

            if (count($namespace)) {
                $value = new NamespacedName(join('', $namespace), $name);
            } else {
                $value = new Name($name);
            }
        }
        return $value;
    }

    function match(TokenStream $stream)
    {
        return $stream->match(
            array_merge(self::$functionLikeConstructs, self::$constants, array(T_STRING, T_NS_SEPARATOR))
        );
    }

}
