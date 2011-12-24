<?php

namespace Mystique\Common\Compiler;

interface Compilable
{
    function compile(CompilerInterface $compiler);
}