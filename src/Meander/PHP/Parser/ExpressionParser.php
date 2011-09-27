<?php

namespace Meander\PHP\Parser;
use \Meander\PHP\Node\Value;
use \Meander\PHP\Token\TokenStream;
use \Meander\PHP\Node\Name;
use \Meander\PHP\Node\NamespacedName;
use \Meander\PHP\Token\Type;
use \Meander\PHP\Token\Operator;
use \Meander\PHP\Node\Call;
use UnexpectedValueException;

class ExpressionParser implements Parser {
    function __construct() {
    }


    function parse(TokenStream $stream) {
        if($stream->match('(')) {
            $stream->next();
            $ret = $this->parse($stream);
            $stream->expect(')');
            $ret->setParens(true);

            if($stream->valid() && $stream->match('(')) {
                $arguments = $this->parseArgumentList($stream, true);
                $ret = new Call($ret, $arguments);
            }
        } else {
            if($stream->match(Operator::$unaryOperators)) {
                $op = $stream->current();
                $operator = new Operator($op);
                $stream->next();
                $rValue = $this->parse($stream);
                if($rValue instanceof \Meander\PHP\Node\ExpressionAbstract) {
                    $precedence = $this->determinePrecedence($rValue, $operator);

                    switch($precedence) {
                        case 'right':
                            $lValue = new \Meander\PHP\Node\UnaryExpression($operator, $rValue);
                            break;
                        case 'left':
                            $lValue= $rValue;
                            $lValue->setLValue(new \Meander\PHP\Node\UnaryExpression($operator, $lValue->getLValue()));
                            break;
                        default: throw new \RuntimeException("Unexpected precedence $precedence");
                    }
                } else {
                    $lValue = new \Meander\PHP\Node\UnaryExpression($operator, $rValue);
                }
            } else {
                $lValue = $this->parseValue($stream);
            }

            if($stream->valid() && $stream->match('(')) {
                $arguments = $this->parseArgumentList($stream, true);
                $lValue = new Call($lValue, $arguments);
            }

            if($stream->valid() && $stream->match(Operator::$binaryOperators)) {
                $op = $stream->current();
                $stream->next();
                $rValue = $this->parse($stream);
                $operator = new Operator($op);

                if($rValue instanceof \Meander\PHP\Node\ExpressionAbstract) {
                    $precedence = $this->determinePrecedence($rValue, $operator);
                    switch($precedence) {
                        case 'right':
                            $ret = new \Meander\PHP\Node\BinaryExpression($lValue, $operator, $rValue);
                            break;
                        case 'left':
                            $ret = $rValue;
                            $ret->setLValue(new \Meander\PHP\Node\BinaryExpression($lValue, $operator, $ret->getLValue()));
                            break;
                        default: throw new \RuntimeException("Unexpected precedence $precedence");
                    }
                } else {
                    $ret = new \Meander\PHP\Node\BinaryExpression($lValue, new Operator($op), $rValue);
                }
            } else {
                $ret = $lValue;
            }
        }
        return $ret;
    }

    public function determinePrecedence($rValue, $operator)
    {
        if ($rValue->hasParens()) {
            $precedence = 'right';
        } else {
            $precedence = Operator::precedence($operator, $rValue->getOperator());

            switch ($precedence) {
                case -1: // lvalue has precedence over rvalue
                    $precedence = 'left';
                    break;
                case 0:
                    if (Operator::getAssociativity($operator) == 'right') {
                        $precedence = 'right';
                    } else {
                        $precedence = 'left';
                    }
                    break;
                case 1:
                    $precedence = 'right';
                    break;
                default:
                    throw new UnexpectedValueException('Invalid precedence returned: ' . $precedence);
            }
        }
        return $precedence;
    }


    function parseValue(TokenStream $stream) {
        $token = $stream->expect(
            array(
                 T_VARIABLE,
                 T_STRING,
                 T_CONSTANT_ENCAPSED_STRING,
                 T_NUM_STRING,
                 T_LNUMBER,
                 T_DNUMBER,
                 T_NS_SEPARATOR
            )
        );

        $value = null;
        switch($token->type) {
            case T_LNUMBER:
                $value = new Value((int)$token->value);
                break;
            case T_DNUMBER:
                $value = new Value((float)$token->value);
                break;
            case T_CONSTANT_ENCAPSED_STRING:
                $value = new Value(substr($token->value, 1, -1));
                break;
            case T_NS_SEPARATOR:
                $namespaceParts = array($stream->expect(T_STRING)->value);
                while($stream->match(T_NS_SEPARATOR)) {
                    $stream->next();
                    $namespaceParts[] = $stream->expect(T_STRING);
                }
                $name = array_pop($namespaceParts);
                $value = new NamespacedName('\\' . implode('\\', $namespaceParts), $name);
                break;
            case T_STRING:
                switch($token->value) {
                    case 'null':
                        $value = new Value(null);
                        break;
                    case 'false':
                        $value = new Value(false);
                        break;
                    case 'true':
                        $value = new Value(true);
                        break;
                    case 'self':
                        $value = new Name($token->value);
                        break;
                    default:
                        if($stream->valid() && $stream->match(T_NS_SEPARATOR)) {
                            $namespaceParts = array($token->value);
                            while($stream->match(T_NS_SEPARATOR)) {
                                $stream->next();
                                $namespaceParts[] = $stream->expect(T_STRING);
                            }
                            $name = array_pop($namespaceParts);
                            $value = new NamespacedName(implode('\\', $namespaceParts), $name);
                        } else {
                            $value = new Name($token->value);
                        }
                        break;
                }
                break;
            case T_VARIABLE:
                $value = new \Meander\PHP\Node\Variable(substr($token->value, 1));
                break;
        }
        return $value;
    }


    function parseArgumentList(TokenStream $stream) {
        $argumentList = new \Meander\PHP\Node\ArgumentList();
        $stream->next();
        if(!$stream->match(')')) {
            while(true) {
                $argumentList->children->append($this->parse($stream));
                if($stream->expect(array(',', ')'))->type == ')') {
                    break;
                }
            }
        } else {
            $stream->next();
        }
        return $argumentList;
    }


    function match(TokenStream $stream) {
        throw new \LogicException("Unimplemented");
    }
}