<?php

namespace Meander\PHP\Node;

class UseDeclaration extends LanguageConstruct {
    function getNodeType()
    {
        return 'UseDeclaration';
    }
}