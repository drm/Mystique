<?php
namespace Mystique\PHP\Token;

use \Mystique\Compiler\CompilerInterface;

class Operator extends Token implements \Mystique\PHP\Node\Leaf, \Mystique\Compiler\Compilable {
    function __construct($token) {
        if($token instanceof Token) {
            parent::__construct(array($token->type, $token->value));
        } else {
            parent::__construct($token);
        }
    }


    static function precedence(Operator $my, Operator $other) {
        $myPrecedence = self::$operators[$my->type][0];
        $theirPrecedence = self::$operators[$other->type][0];
        return
                $myPrecedence == $theirPrecedence
                ? 0
                : $myPrecedence > $theirPrecedence
                ? -1
                : 1
        ;
    }



    // TODO refactor into regular method
    static function getAssociativity(Operator $op) {
        return self::$operators[$op->type][1];
    }


    public static $operators = array(
        T_OBJECT_OPERATOR        => array(22, 'left'),
        T_PAAMAYIM_NEKUDOTAYIM   => array(22, 'left'),
        T_CLONE                  => array(21, 'non-associative'),
        T_NEW                    => array(21, 'non-associative'),
        '['                      => array(20, 'left'),
        '{'                      => array(20, 'left'),
        '('                      => array(20, 'left'),
        T_INC                    => array(19, 'non-associative'),
        T_DEC                    => array(19, 'non-associative'),
        '~'                      => array(18, 'right'),
        '-'                      => array(18, 'right'),
        T_INT_CAST               => array(18, 'right'),
        T_DOUBLE_CAST            => array(18, 'right'),
        T_STRING_CAST            => array(18, 'right'),
        T_ARRAY_CAST             => array(18, 'right'),
        T_OBJECT_CAST            => array(18, 'right'),
        T_BOOL_CAST              => array(18, 'right'),
        '@'                      => array(18, 'right'),
        T_INSTANCEOF             => array(17, 'non-associative'),
        '!'                      => array(16, 'right'),
        '*'                      => array(15, 'left'),
        '/'                      => array(15, 'left'),
        '%'                      => array(15, 'left'),
        '+'                      => array(14, 'left'),
        '-'                      => array(14, 'left'),
        '.'                      => array(14, 'left'),
        T_SL                     => array(13, 'left'),
        T_SR                     => array(13, 'left'),
        '<'                      => array(12, 'non-associative'),
        T_IS_SMALLER_OR_EQUAL    => array(12, 'non-associative'),
        '>'                      => array(12, 'non-associative'),
        T_IS_GREATER_OR_EQUAL    => array(12, 'non-associative'),
        T_IS_NOT_EQUAL           => array(12, 'non-associative'),
        T_IS_EQUAL               => array(11, 'non-associative'),
        T_IS_NOT_EQUAL           => array(11, 'non-associative'),
        T_IS_IDENTICAL           => array(11, 'non-associative'),
        T_IS_NOT_IDENTICAL       => array(11, 'non-associative'),
        '&'                      => array(10, 'left'),
        '^'                      => array(9, 'left'),
        '|'                      => array(8, 'left'),
        T_BOOLEAN_AND            => array(7, 'left'),
        T_BOOLEAN_OR             => array(6, 'left'),
        '?'                      => array(5, 'left'),
        ':'                      => array(5, 'left'),
        '='                      => array(4, 'right'),
        T_PLUS_EQUAL             => array(4, 'right'),
        T_MINUS_EQUAL            => array(4, 'right'),
        T_MUL_EQUAL              => array(4, 'right'),
        T_DIV_EQUAL              => array(4, 'right'),
        T_CONCAT_EQUAL           => array(4, 'right'),
        T_MOD_EQUAL              => array(4, 'right'),
        T_AND_EQUAL              => array(4, 'right'),
        T_OR_EQUAL               => array(4, 'right'),
        T_XOR_EQUAL              => array(4, 'right'),
        T_SL_EQUAL               => array(4, 'right'),
        T_SR_EQUAL               => array(4, 'right'),
        T_DOUBLE_ARROW           => array(4, 'right'),
        T_LOGICAL_AND            => array(3, 'left'),
        T_LOGICAL_XOR            => array(2, 'left'),
        T_LOGICAL_OR             => array(1, 'left'),
        ','                      => array(0, 'left')
    );

    public static $unaryOperators = array(
        T_INC, T_DEC,
        T_CLONE, T_NEW, '!',
        '-', '+', '~', '@', '&',
        T_INT_CAST,
        T_DOUBLE_CAST,
        T_STRING_CAST,
        T_ARRAY_CAST,
        T_OBJECT_CAST,
        T_BOOL_CAST,
    );


    public static $subscriptOperators = array(
        '{',
        '[',
        '(',
        T_DEC,
        T_INC
    );

    public static $binaryOperators = array(
        T_OBJECT_OPERATOR,
        T_PAAMAYIM_NEKUDOTAYIM,
        '-',
        T_INT_CAST,
        T_DOUBLE_CAST,
        T_STRING_CAST,
        T_ARRAY_CAST,
        T_OBJECT_CAST,
        T_BOOL_CAST,
        '@',
        T_INSTANCEOF,
        '!',
        '*',
        '/',
        '%',
        '+',
        '-',
        '.',
        T_SL,
        T_SR,
        '<',
        T_IS_SMALLER_OR_EQUAL,
        '>',
        T_IS_GREATER_OR_EQUAL,
        T_IS_NOT_EQUAL,
        T_IS_EQUAL,
        T_IS_NOT_EQUAL,
        T_IS_IDENTICAL,
        T_IS_NOT_IDENTICAL,
        '&',
        '^',
        '|',
        T_BOOLEAN_AND,
        T_BOOLEAN_OR,
        '?',
        ':',
        '=',
        T_PLUS_EQUAL,
        T_MINUS_EQUAL,
        T_MUL_EQUAL,
        T_DIV_EQUAL,
        T_CONCAT_EQUAL,
        T_MOD_EQUAL,
        T_AND_EQUAL,
        T_OR_EQUAL,
        T_XOR_EQUAL,
        T_SL_EQUAL,
        T_SR_EQUAL,
        T_DOUBLE_ARROW,
        T_LOGICAL_AND,
        T_LOGICAL_XOR,
        T_LOGICAL_OR,
//        ',',
    );

    function getNodeValue()
    {
        return $this->value;
    }

    function getNodeType()
    {
        return preg_replace('/^.*\\\\([^\\\\]+)$/', '$1', get_class($this));
    }

    function compile(CompilerInterface $compiler)
    {
        $compiler->write($this->value);
    }

    function getNodeAttributes()
    {
    }


    function __toString() {
        return $this->value;
    }
}