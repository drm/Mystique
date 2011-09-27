<?php
namespace Meander\PHP\Node;

//TODO do we really need this class?
abstract class VariableAbstract extends LeafAbstract implements \Meander\Compiler\Compilable
{
    function compileName(\Meander\Compiler\CompilerInterface $compiler, $name)
    {
        if(!preg_match('/^[a-z_]\w*$/i', $name)) {
            $compiler->write('{' .  var_export($name, true) . '}');
        } else {
            $compiler->write($name);
        }
    }
}