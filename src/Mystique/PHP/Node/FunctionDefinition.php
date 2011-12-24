<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\NodeList;

class FunctionDefinition extends DefinitionAbstract {
    function setBody($body) {
        $this->children = new NodeList();
        $this->children->append($body);
    }
}