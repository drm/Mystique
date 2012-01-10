<?php
namespace Mystique\PHP\Inspector\Matcher;

use Mystique\Common\Inspector\Matcher\Aggregate;
use Mystique\Common\Inspector\Matcher\NodeType;
use Mystique\Common\Inspector\Matcher\Callback;

class FunctionCall extends Aggregate {
    function __construct($name) {
        parent::__construct(self::ALL);
        $this->name = $name;
        $this->filters[]= new NodeType('Mystique\PHP\Node\Call');
        $this->filters[]= new Callback(
            array($this, 'matchLeftOperand')
        );
    }


    function matchLeftOperand(\Mystique\PHP\Node\Call $call) {
        $ret = $call->getLeft() instanceof \Mystique\PHP\Node\Name;
        if($this->name) {
            $ret = $ret && (strcasecmp($call->getLeft()->getNodeValue(), $this->name) == 0);
        }
        return $ret;
    }
}