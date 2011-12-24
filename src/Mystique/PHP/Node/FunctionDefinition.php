<?php

namespace Mystique\PHP\Node;

class FunctionDefinition extends DefinitionAbstract {
    function setBody($body) {
        $this->children = new NodeList();
        $this->children->append($body);
    }
}