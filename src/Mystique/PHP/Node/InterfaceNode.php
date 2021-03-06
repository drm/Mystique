<?php

namespace Mystique\PHP\Node;

use \Mystique\Common\Compiler\Compilable;
use \Mystique\Common\Compiler\CompilerInterface;
use Mystique\Common\Ast\Node\NodeList;

class InterfaceNode extends DefDeclNodeAbstract {
    protected $doc = null;

    function __construct($name = null) {
        parent::__construct();
        if($name) {
            $this->setName(new Name($name));
        }
    }

    function setDeclaration()
    {
        $this->children[0] = new InterfaceDeclaration();
    }

    function setDefinition(NodeList $definition)
    {
        $this->children[1] = new InterfaceDefinition($definition);
    }
    

    function getNodeType()
    {
        return 'Interface';
    }
}

