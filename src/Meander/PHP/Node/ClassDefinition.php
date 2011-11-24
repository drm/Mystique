<?php

namespace Meander\PHP\Node;

class ClassDefinition extends DefinitionAbstract {
    function addMember($member) {
        $this->add($member);
    }
}