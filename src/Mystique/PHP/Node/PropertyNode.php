<?php

namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\NodeList;

class PropertyNode extends \Mystique\PHP\Node\DefDeclNodeAbstract {
    function setDeclaration()
    {
        $this->children[0] = new PropertyDeclaration();
    }

    function getNodeType()
    {
        return 'Property';
    }

    function addDefinition(PropertyDefinition $defn)
    {
        $this->children->append($defn);
    }

    function setDefinition(NodeList $definition)
    {
        foreach($definition as $def) {
            $this->addDefinition($def);
        }
    }

    function compile(\Mystique\Common\Compiler\CompilerInterface $compiler)
    {
        $compiler->compile($this->children[0]);

        for($i = 1; $i < count($this->children); $i ++) {
            if($i > 1) {
                $compiler->write(',');
            }
            $compiler->compile($this->children[$i]);
        }
        $compiler->write(';');
    }
}