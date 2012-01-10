<?php

namespace Mystique\Annotation\Node;

class NameValuePair extends \Mystique\Common\Ast\Node\BranchAbstract {
    function setName($name) {
        $this->children[0] = new \Mystique\PHP\Node\Name($name);
    }


    function setValue($value) {
        $this->children[1] = $value;
    }
}