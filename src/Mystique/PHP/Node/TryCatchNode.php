<?php
namespace Mystique\PHP\Node;
use Mystique\Common\Ast\Node\BranchAbstract;
use Mystique\Common\Ast\Node\NodeList;

class TryCatchNode extends BranchAbstract {
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