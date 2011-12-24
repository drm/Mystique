<?php
namespace Mystique\PHP\Node;

use Mystique\Common\Ast\Node\LeafAbstract;

//TODO do we really need this class?
abstract class VariableAbstract extends LeafAbstract implements \Mystique\Common\Compiler\Compilable
{
    function compileName(\Mystique\Common\Compiler\CompilerInterface $compiler, $name)
    {
        if(!preg_match('/^[a-z_]\w*$/i', $name)) {
            $compiler->write('{' .  var_export($name, true) . '}');
        } else {
            $compiler->write($name);
        }
    }
}