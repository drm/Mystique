<?php

namespace  Mystique\Common\Inspector\Matcher;

use Mystique\Common\Ast\Node\Node;

class Aggregate implements MatcherInterface {
    const ANY = 'ANY';
    const ALL = 'ALL';


    function __construct($mode = self::ANY, array $filters = array()) {
        $this->mode = $mode;
        $this->filters = $filters;
    }


    function match(Node $node) {
        if($this->mode == self::ANY) {
            $ret = false;
            foreach($this->filters as $filter) {
                if($filter->match($node)) {
                    $ret = true;
                    break;
                }
            }
        } else {
            $ret = true;
            foreach($this->filters as $filter) {
                if(!$filter->match($node)) {
                    $ret = false;
                    break;
                }
            }
        }
        return $ret;
    }

}