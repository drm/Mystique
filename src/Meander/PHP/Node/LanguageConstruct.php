<?php

namespace Meander\PHP\Node;

class LanguageConstruct extends Statement {
    function __construct($type, $expression) {
        parent::__construct($expression);
        $this->type = $type;
    }

    function getNodeType() {
        return $this->type;
    }
}