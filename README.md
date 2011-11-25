# Meander: the PHP code analysis, generation, inspection and refactoring library #

Meander is a library that provides tools for easily inspection, analyzing, generating and refactoring PHP code. The
library consists of five separate loosely coupled components: the **parser**, the **compiler**, the **inspector** and
the **builder** and **refactoring**. Combining these components allow you to:

* Generate an AST from PHP source code without using reflection
* Refactor PHP code by writing code migration scripts
* Inspect code for certain (anti)patterns
* Compile other formats into PHP code (code generation)
* Compile multiple PHP files into singles (code deflation)
* Compile annotations

## Examples ##
### Backward compatibility refactoring ###
If you wanted to release a new version of your library that breaks Backward Compatibility, you can provide scripts
to inspect code for "the old way" and provide refactoring tools for the new way.

#### Example ####
The old version of the library had a class named Foo which had a constructor that accepted three arguments. The new
version accepts only one argument, which contains the same options as an array. You can apply a refactoring by using
the following refactoring plugin:

````
class FooNowAcceptsOnlyArrays implements \Meander\Refactoring\Refactoring {
    function finder() {
        return new \Meander\PHP\Inspector\Usage('\Foo', '__construct');
    }


    function apply(Node $n) {
        if($n instanceof Call) {
            $expr = new Call(new Name('array'));
            $expr->setParameters($n->getParameters());
            $n->setParameters(new ExprList(array($expr)));
        }
    }
}

````
$ meander refactor -p FooNowAcceptsOnlyArrays
Warning: searching for usages is not necessarily safe. Use -v to show possibly false positive usages
1 usage found:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(new Bar(), new Baz(), new Qux());"

1 refactoring available:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(array('baz' => new Bar(), 'bar' => new Baz(), 'qux' => new Qux()));"

$ meander refactor -d FooNowAcceptsOnlyArrays
Warning: searching for usages is not necessarily safe. Use -v to show possibly false positive usages
1 usage found:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(new Bar(), new Baz(), new Qux());"

1 refactoring available:
my/lib/FooConsumer.php, line 12:     "        $foo = new Foo(array('baz' => new Bar(), 'bar' => new Baz(), 'qux' => new Qux()));"


The refactoring can generate a diff, or apply the changes directly.

### Aspect Oriented Programming and Mixins ###
By providing annotations to pieces of code, you can add Aspect Oriented programming to PHP, which it natively does
not support. It does so by Mixins, which simply process the classes, functions or methods you apply the mixin to.
Meander comes with a set of default mixins that handle the dirty work for you. Of course, you can apply multiple
mixins to a single method or class, they just get chained iteratively.

/**
 * @Meander\Processor\Mixin(\My\Aspect)
 */

### Auto-compilation ###
Since Meander provides its own autoloader, there is a simple way to divert from standard autoloading and have the
autoloader take care of class compilation for you. This way, you don't have to worry about compiling code before running
it, the autoloader will take care of that. There are two default strategies available for auto-compilation.

#### Same-folder compilation ####
Following Python, Meander comes with "same folder compilation", which puts the compiled versions of files directly next
to the source files. You can define your own renaming algorithm, but by default the .php suffix is replaced by a .c.php
suffix. The autoloader works nice with this, so it detects whether a compiled file is available, and if not, recompiles
it using your own compiler directives.

### Pre-processor directives ###
PHP misses a simple feature that is available in C and C++. Preprocessing. PHP does, however, have a hash symbol that is
rarely used for just comments. Meander comes with a set of preprocessing tools that allow you to add logic to the code
that you would not want available in all distributions of your code. For example, in production environments it would

## Roadmap ##

The following things are on the roadmap:

### Compatibility ###

* phpcpd (PHP Copy/Paste detector)
* phpcs (PHP CodeSniffer)
* docblox (Generating documentation)
* Twig (Compilation of Twig Templates)

### Implement a BNF parser generator ###

### Transcoding ###

* Generate other languages from PHP files
* Generate PHP code from other languages