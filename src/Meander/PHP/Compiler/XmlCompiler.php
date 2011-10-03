<?php

namespace Meander\PHP\Compiler;

use \Meander\PHP\Node\Visitor;
use \Meander\PHP\Node\Node;
use \Meander\PHP\Node\Leaf;
use SimpleXMLElement;
use RuntimeException;

class XmlCompiler implements Visitor {
    protected $_stack = array();

    function __construct() {
        $this->_stack = array(new SimpleXmlElement('<ast />'));
    }


    function enterNode(Node $node)
    {
        /** @var \SimpleXMLElement $parent */
        $parent = array_pop($this->_stack);
        $nodeName = $node->getNodeType();
        $nodeName = preg_replace_callback(
            '/(.|^)([A-Z])/',
            function($m) {
                return ($m[1] ? $m[1] . '-' : '') . strtolower($m[2]);
            },
            $nodeName
        );
        if($node instanceof Leaf) {
            $child = $parent->addChild($nodeName, htmlspecialchars($node->getNodeValue()));
        } else {
            $child = $parent->addChild($nodeName);
        }
        foreach((array)$node->getNodeAttributes() as $name => $value) {
            $child[$name] = (string)$value;
        }
        array_push($this->_stack, $parent);
        array_push($this->_stack, $child);
    }
    

    function exitNode(Node $node)
    {
        array_pop($this->_stack);
    }


    function __toString() {
        if(count($this->_stack) != 1) {
            throw new RuntimeException('The compiler stack is not of the expected size, (1)');
        }
        $dom = dom_import_simplexml($this->_stack[0])->ownerDocument;
        $dom->formatOutput = true;
        return $dom->saveXML();
    }
}