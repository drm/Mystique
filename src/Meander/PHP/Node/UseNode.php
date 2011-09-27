<?php
namespace Meander\PHP\Node;

class UseNode extends LanguageConstruct {
    function __construct($expression, $alias) {
        parent::__construct('use', $expression);

        if($alias) {
            $this->children->append($alias);
        }
    }
}