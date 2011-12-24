<?php
namespace Mystique\PHP\Node;

class TryCatchNode extends \Mystique\PHP\Node\BranchAbstract {
    function setTry(NodeList $try) {
        $this->children[0] = new TryNode($try);
    }


    function addCatch($name, $var, $catch) {
        $node = new CatchNode();
        $node->setType($name);
        $node->setVariable($var);
        $node->setDefinition($catch);
        $this->children->append($node);
    }


    function getNodeType() {
        return 'TryCatch';
    }
}