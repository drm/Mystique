<?php

namespace Meander\PHP;

use SimpleXMLElement;

class Ast {
    function asXml() {
        $ret = new SimpleXMLElement('<ast />');

        foreach($this->_rootNode->getChildren() as $child) {
            $this->_asXml($child);
        }
    }
}