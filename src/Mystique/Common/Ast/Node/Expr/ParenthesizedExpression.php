<?php
namespace Mystique\Common\Ast\Node\Expr;

use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Compiler\CompilerInterface;

class ParenthesizedExpression extends BranchAbstract {
    public static $defaultType = '(';

    function __construct($expression = null, $type = null)
    {
        parent::__construct();
        if($expression) {
            $this->setExpression($expression);
        }
        if ($type && $type != self::$defaultType) {
            $this->setAttribute('type', $type);
        }
    }


    function setExpression($expression) {
        $this->children[0] = $expression;
    }


    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler) {
        if (!($type = $this->getAttribute('type'))) {
            $type = self::$defaultType;
        }
        $compiler->write($type);
        parent::compile($compiler);
        $compiler->write(\Mystique\Common\Util\PairMatcher::parenOf($type));
    }

    function getNodeType()
    {
        return 'Paren';
    }
}