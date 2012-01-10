<?php

namespace Mystique\Annotation\Node;

class AnnotationNode extends \Mystique\Common\Ast\Node\BranchAbstract {
    function setName($name) {
        $this->children[0] = new \Mystique\PHP\Node\Name($name);
    }


    function setArgs(ArgumentsNode $args) {
        $this->children[1] = $args;
    }
}